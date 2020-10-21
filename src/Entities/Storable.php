<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Item;
use Habitissimo\Entities\StorableException;

abstract class Storable
{
    protected array $items = [];

    abstract public function isFull(): bool;

    public function addItem(Item $an_item): void
    {
        $this->items[] = $an_item;
    }

    public function item($index): Item
    {
        if (isset($this->items[$index])) {
            return $this->items[$index];
        }
        throw StorableException::nonExistentItem();
    }

    public function empty(): void
    {
        $this->items = [];
    }

    public function countItems(): int
    {
        return count($this->items);
    }

    public function allItems(): array
    {
        return $this->items;
    }

    public function sort(): void
    {
        usort($this->items, function($itemA, $itemB) {
            return strcmp($itemA->name(), $itemB->name());
        });
    }

    public function removeItem(Item $a_item): void
    {
        $index = array_search($a_item, $this->items, true);
        if ($index !== false) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function itemsByCategory(Category $a_category): array
    {
        return array_values(array_filter($this->items, function ($item) use ($a_category) {
            return $item->category() === $a_category;
        }));
    }
}
