<?php

declare(strict_types=1);

namespace Habitissimo\Entities;

use Exception;

final class StorableException extends Exception
{
    public static function tooMuchBags(): self
    {
        return new self('Too much bags');
    }

    public static function notEnoughBags(): self
    {
        return new self('There is not enough bags to stash the item');
    }

    public static function nonExistentBag(): self
    {
        return new self('Non-existent bag');
    }

    public static function nonExistentItem(): self
    {
        return new self('Non-existent item');
    }
}