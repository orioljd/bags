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
}