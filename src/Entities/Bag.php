<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Storable;
use Habitissimo\Entities\Category;

class Bag extends Storable
{
    private ?Category $category;
    private const MAX_ITEMS = 4;

    public function __construct(Category $a_category = null)
    {
        $this->category = $a_category;
    }

    public function isFull(): bool
    {
        return count($this->items) == self::MAX_ITEMS;
    }

    public function category(): ?Category
    {
        return $this->category;
    }
}
