<?php

declare(strict_types = 1);

namespace Test\Entities;

use PHPUnit\Framework\TestCase;
use Habitissimo\Entities\Item;
use Habitissimo\Entities\Category;

class ItemTest extends TestCase
{
    public function testName()
    {
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);

        $this->assertEquals('Leather', $item->name());
    }
}