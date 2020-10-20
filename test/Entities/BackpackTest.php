<?php

declare(strict_types = 1);

namespace Test\Entities;

use Habitissimo\Entities\Item;
use Habitissimo\Entities\Category;
use Habitissimo\Entities\Backpack;
use PHPUnit\Framework\TestCase;

class BackpackTest extends TestCase
{
    public function testIsNotFull()
    {
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);
        $backpack = new Backpack();
        $backpack->addItem($item);

        $this->assertFalse($backpack->isFull());
    }

    public function testIsFull()
    {
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);
        $backpack = new Backpack();
        for ($i=0; $i < 8; $i++) {
            $backpack->addItem(clone $item);
        }

        $this->assertTrue($backpack->isFull());
    }

    public function testExistItem()
    {
        $category = new Category('Clothes');

        $backpack = new Backpack();
        $backpack->addItem(new Item('Leather', $category));
        $backpack->addItem(new Item('Silk', $category));
        $silkItem = $backpack->item(1);

        $this->assertEquals('Silk', $silkItem->name());
    }

    public function testNonExistentItem()
    {
        $this->expectExceptionMessage('Non-existent item');
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);

        $backpack = new Backpack();
        for ($i=0; $i < 7; $i++) {
            $backpack->addItem(clone $item);
        }
        $backpack->item(7);
    }
}