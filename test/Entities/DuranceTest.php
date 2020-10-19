<?php

declare(strict_types = 1);

namespace Test\Entities;

use Habitissimo\Entities\Category;
use Habitissimo\Entities\Bag;
use Habitissimo\Entities\Backpack;
use Habitissimo\Entities\Durance;
use Habitissimo\Entities\Item;
use PHPUnit\Framework\TestCase;

class DuranceTest extends TestCase
{
    public function testTooMuchBags()
    {
        $this->expectExceptionMessage('Too much bags');

        $bags = [];
        for ($i=0; $i < 5; $i++) {
            $bags[] = new Bag();
        }

        new Durance(new Backpack(), $bags);
    }

    public function testNonExistentBag()
    {
        $this->expectExceptionMessage('Non-existent bag');

        $durance = new Durance(new Backpack(), [new Bag()]);

        $durance->bag(1);
    }

    public function testExistBag()
    {
        $category = new Category('Herbs');
        $durance = new Durance(new Backpack(), [new Bag($category)]);

        $bag = $durance->bag(0);
        $this->assertEquals('Herbs', $bag->category()->name());
    }

    public function testStashItemsInBags()
    {
        $firstCategory = new Category('Herbs');
        $secondCategory = new Category('Weapons');
        $durance = new Durance(new Backpack(), [new Bag($firstCategory), new Bag($secondCategory)]);

        $this->stashItems($durance, 12); // fill backpack and 1st bag
        $durance->stashItem(new Item('Rose', $firstCategory));
        $durance->stashItem(new Item('Seaweed', $firstCategory));
        $durance->stashItem(new Item('Dagger', $secondCategory));

        $thirdItemOfSecondBag = $durance->bag(1)->item(2);
        $this->assertEquals('Dagger', $thirdItemOfSecondBag->name());
    }

    public function testNotEnoughBags()
    {
        $this->expectExceptionMessage('There is not enough bags to stash the item');

        $durance = new Durance(new Backpack(), []);

        $this->stashItems($durance, 9);
    }

    private function stashItems($durance, $times): void
    {
        $category = new Category('Herbs');
        $item = new Item('Marigold', $category);

        for ($i = 0; $i < $times; $i++) {
            $durance->stashItem(clone $item);
        }
    }
}