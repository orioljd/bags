<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Bag;
use Habitissimo\Entities\Item;
use Habitissimo\Entities\OrganizerBag;
use Habitissimo\Entities\StorableException;

class Durance
{
    private const MAX_BAGS = 4;
    private array $bags = [];
    private Backpack $backpack;
    private OrganizerBag $organizerBag;

    public function __construct(Backpack $a_bagpack, array $some_bags)
    {
        $this->addBags($some_bags);
        $this->backpack = $a_bagpack;
        $this->organizerBag = new OrganizerBag;
    }

    private function addBags(array $bags_to_add): void
    {
        if ((count($bags_to_add) + count($this->bags)) > self::MAX_BAGS) {
            throw StorableException::tooMuchBags();
        }

        $this->bags = array_merge($this->bags, $bags_to_add);
    }

    public function stashItem(Item $an_item): void
    {
        if ($this->backpack->isFull()) {
            $this->stashInBags($an_item);
            return;
        }

        $this->backpack->addItem($an_item);
    }

    private function stashInBags(Item $an_item): void
    {
        foreach ($this->bags as $bag) {
            if (!$bag->isFull()) {
                $bag->addItem($an_item);
                return;
            }
        }
        throw StorableException::notEnoughBags();
    }

    public function backpack(): Backpack
    {
        return $this->backpack;
    }

    public function bag($index): Bag
    {
        if (isset($this->bags[$index])) {
            return $this->bags[$index];
        }
        throw StorableException::nonExistentBag();
    }

    public function organize(): void
    {
        $this->organizerBag->empty();
        $this->organizerBag->fill(array_merge([$this->backpack], $this->bags));
        $this->emptyAllBags();
        $this->moveItems();
        $this->sortAllBags();
    }

    private function emptyAllBags(): void
    {
        $this->backpack->empty();

        foreach ($this->bags as $bag) {
            $bag->empty();
        }
    }

    private function sortAllBags(): void
    {
        $this->backpack->sort();

        foreach ($this->bags as $bag) {
            $bag->sort();
        }
    }

    private function moveItems(): void
    {
        foreach ($this->bags as $bag) {
            $category = $bag->category();
            if ($category !== null) {
                $categoryItems = $this->organizerBag->itemsByCategory($category);
                $this->swapBags($categoryItems, $bag);
            }
        }

        if ($this->organizerBag->countItems() > 0) {
            $restItems = $this->organizerBag->allItems();
            $this->swapBags($restItems, $this->backpack);
        }
    }

    private function swapBags(array $itemsToSwap, $destination): void
    {
        foreach ($itemsToSwap as $item) {
            $this->organizerBag->removeItem($item);
            $destination->addItem($item);
            if ($destination->isFull()) {
                break;
            }
        }
    }
}
