<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Storable;

class OrganizerBag extends Storable
{
    public function isFull(): bool
    {
        return false;
    }

    public function fill(array $some_bags): void
    {
        foreach ($some_bags as $bag) {
            $bagItems = $bag->allItems();
            $this->items = array_merge($this->items, $bagItems);
        }
        $this->sort();
    }
}
