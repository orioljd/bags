<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

class Category
{
    private string $name;

    public function __construct(string $a_name)
    {
        $this->name = $a_name;
    }

    public function name(): string
    {
        return $this->name;
    }
}