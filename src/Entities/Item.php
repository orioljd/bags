<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Habitissimo\Entities\Category;

class Item
{
    private string $name;
    private Category $category;

    public function __construct(string $a_name,  Category $a_category)
    {
        $this->name = $a_name;
        $this->category = $a_category;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): Category
    {
        return $this->category;
    }
}
