<?php

declare(strict_types = 1);

namespace Test\Entities;

use PHPUnit\Framework\TestCase;
use Habitissimo\Entities\Category;

class CategoryTest extends TestCase
{
    public function testName()
    {
        $category = new Category('Clothes');

        $this->assertEquals('Clothes', $category->name());
    }
}