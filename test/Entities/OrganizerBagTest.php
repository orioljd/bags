<?php

declare(strict_types = 1);

namespace Test\Entities;

use Habitissimo\Entities\Item;
use Habitissimo\Entities\Category;
use Habitissimo\Entities\OrganizerBag;
use PHPUnit\Framework\TestCase;

class OrganizerBagTest extends TestCase
{
    public function testIsNotFull()
    {
        $category = new Category('Clothes');
        $item = new Item('Leather', $category);
        $organizerBag = new OrganizerBag();

        $organizerBag->addItem($item);

        $this->assertFalse($organizerBag->isFull());
    }

}