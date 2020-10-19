<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Storable;

class Backpack extends Storable
{
    private const MAX_ITEMS = 8;

    public function isFull(): bool
    {
        return count($this->items) == self::MAX_ITEMS;
    }
}
