<?php

declare(strict_types = 1);

namespace Test\Entities;

use Habitissimo\Entities\Bag;
use Habitissimo\Entities\Item;
use Habitissimo\Entities\Category;
use PHPUnit\Framework\TestCase;

class StorableTest extends TestCase
{
    private Bag $bag;
    private Category $category;

    public function testExistItem()
    {
        $this->createBagAndAddItems(2);
        $silkItem = $this->bag->item(1);
        $this->assertEquals('Wool', $silkItem->name());
    }

    private function createBagAndAddItems($number_of_items = 0)
    {
        $this->category = new Category('Clothes');
        $item = new Item('Wool', $this->category);

        $this->bag = new Bag();
        for ($i=0; $i < $number_of_items; $i++) {
            $this->bag->addItem(clone $item);
        }
    }

    public function testNonExistentItem()
    {
        $this->expectExceptionMessage('Non-existent item');
        $this->createBagAndAddItems(2);
        $this->bag->item(7);
    }

    public function testCountAndEmptyBag()
    {
        $this->createBagAndAddItems(2);
        $numberOfItems = $this->bag->countItems();
        $this->assertEquals(2, $numberOfItems);

        $this->bag->empty();

        $numberOfItems = $this->bag->countItems();
        $this->assertEquals(0, $numberOfItems);
    }

    public function testGetItems()
    {
        $this->createBagAndAddItems(3);
        $items = $this->bag->allItems();
        $this->assertEquals(3, count($items));
    }

    public function testSortBag()
    {
        $this->createBagAndAddItems();
        $this->bag->addItem(new Item('Wool', $this->category));
        $this->bag->addItem(new Item('Silk', $this->category));
        $this->bag->addItem(new Item('Leather', $this->category));
        $this->bag->addItem(new Item('Wool', $this->category));
        $this->bag->sort();

        $this->assertEquals('Leather', $this->bag->item(0)->name());
        $this->assertEquals('Silk', $this->bag->item(1)->name());
        $this->assertEquals('Wool', $this->bag->item(2)->name());
        $this->assertEquals('Wool', $this->bag->item(3)->name());
    }

    public function testGetItemsByCategory()
    {
        $categoryClothes = new Category('Clothes');
        $categoryMetal = new Category('Metals');
        $categoryHerbs = new Category('Herbs');

        $bag = new Bag();
        $bag->addItem(new Item('Leather', $categoryClothes));
        $bag->addItem(new Item('Gold', $categoryMetal));
        $bag->addItem(new Item('Silk', $categoryClothes));
        $bag->addItem(new Item('Rose', $categoryHerbs));

        $items = $bag->itemsByCategory($categoryClothes);
        $this->assertEquals(2, count($items));
        $this->assertEquals('Leather', $items[0]->name());
        $this->assertEquals('Silk', $items[1]->name());

        $items = $bag->itemsByCategory($categoryHerbs);
        $this->assertEquals('Rose', $items[0]->name());

        $items = $bag->itemsByCategory($categoryMetal);
        $this->assertEquals('Gold', $items[0]->name());
    }

    public function testRemoveItem()
    {
        $this->createBagAndAddItems();
        $wool = new Item('Wool', $this->category);
        $silk = new Item('Silk', $this->category);
        $linen = new Item('Linen', $this->category);
        $leather = new Item('Leather', $this->category);

        $this->bag->addItem($wool);
        $this->bag->addItem($silk);
        $this->bag->addItem($linen);
        $this->bag->addItem($leather);
        $this->assertEquals('Linen', $this->bag->item(2)->name());

        $this->bag->removeItem($linen);
        $this->assertEquals('Leather', $this->bag->item(2)->name());
    }
}
