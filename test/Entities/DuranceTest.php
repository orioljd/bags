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
    private Durance $durance;

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
        $this->durance = new Durance(new Backpack(), [new Bag($firstCategory), new Bag($secondCategory)]);

        $this->stashItems(12);
        $this->durance->stashItem(new Item('Rose', $firstCategory));
        $this->durance->stashItem(new Item('Seaweed', $firstCategory));
        $this->durance->stashItem(new Item('Dagger', $secondCategory));

        $thirdItemOfSecondBag = $this->durance->bag(1)->item(2);
        $this->assertEquals('Dagger', $thirdItemOfSecondBag->name());
    }

    private function stashItems ($times): void
    {
        $category = new Category('Herbs');
        $item = new Item('Marigold', $category);

        for ($i = 0; $i < $times; $i++) {
            $this->durance->stashItem(clone $item);
        }
    }

    public function testNotEnoughBags()
    {
        $this->expectExceptionMessage('There is not enough bags to stash the item');

        $this->durance = new Durance(new Backpack(), []);

        $this->stashItems(9);
    }

    public function testOrganize()
    {
        $categoryClothes = new Category('Clothes');
        $categoryMetals = new Category('Metals');
        $categoryHerbs = new Category('Herbs');
        $categoryWeapons = new Category('Weapons');

        $this->durance = new Durance(new Backpack(), [new Bag($categoryClothes), new Bag($categoryMetals), new Bag($categoryHerbs), new Bag()]);
        $this->durance->stashItem(new Item('Leather', $categoryClothes));
        $this->durance->stashItem(new Item('Gold', $categoryMetals));
        $this->durance->stashItem(new Item('Silk', $categoryClothes));
        $this->durance->stashItem(new Item('Axe', $categoryWeapons));
        $this->durance->stashItem(new Item('Rose', $categoryHerbs));
        $this->durance->stashItem(new Item('Wool', $categoryClothes));
        $this->durance->stashItem(new Item('Dagger', $categoryWeapons));
        $this->durance->stashItem(new Item('Iron', $categoryMetals));

        $this->durance->stashItem(new Item('Cherry Blossom', $categoryHerbs));
        $this->durance->stashItem(new Item('Copper', $categoryMetals));
        $this->durance->stashItem(new Item('Sword', $categoryWeapons));
        $this->durance->stashItem(new Item('Marigold', $categoryHerbs));

        $this->durance->stashItem(new Item('Wool', $categoryClothes));
        $this->durance->stashItem(new Item('Linen', $categoryClothes));

        $this->durance->organize();

        $this->assertEquals('Axe', $this->durance->backpack()->item(0)->name());
        $this->assertEquals('Wool', $this->durance->backpack()->item(3)->name());
        $this->assertEquals('Linen', $this->durance->bag(0)->item(1)->name());
        $this->assertEquals('Wool', $this->durance->bag(0)->item(3)->name());
        $this->assertEquals('Gold', $this->durance->bag(1)->item(1)->name());
        $this->assertEquals('Iron', $this->durance->bag(1)->item(2)->name());
        $this->assertEquals('Cherry Blossom', $this->durance->bag(2)->item(0)->name());
        $this->assertEquals('Marigold', $this->durance->bag(2)->item(1)->name());
    }
}