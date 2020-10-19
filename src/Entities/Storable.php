<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Item;
use Habitissimo\Entities\StorableException;

abstract class Storable
{
    protected array $items = [];

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
    abstract public function isFull(): bool;
}
