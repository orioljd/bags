<?php

declare(strict_types = 1);

namespace Test\Entities;

use Habitissimo\Entities\Item;
use Habitissimo\Entities\Category;
use Habitissimo\Entities\Bag;
use PHPUnit\Framework\TestCase;

class BagTest extends TestCase
{
    public function testIsNotFull()
    {
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);
        $bag = new Bag();
        $bag->addItem($item);

        $this->assertFalse($bag->isFull());
    }

    public function testIsFull()
    {
        $categoryItem = new Category('Clothes');
        $item = new Item('Leather', $categoryItem);
        $bag = new Bag();
        for ($i=0; $i < 4; $i++) {
            $bag->addItem($item);
        }

        $this->assertTrue($bag->isFull());
    }

    public function testCategoryBag()
    {
        $category = new Category('Metal');
        $bag = new Bag($category);

        $this->assertEquals('Metal', $bag->category()->name());
    }

    public function testCategoryBagIsNull()
    {
        $bag = new Bag();

        $this->assertNull($bag->category());
    }
}