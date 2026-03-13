<?php

namespace App\Domain\Exception;

use DomainException;

class InvalidMiddoException extends DomainException
{
    public static function emptyId(): self
    {
        return new self('Middo ID cannot be empty.');
    }

    public static function emptyName(): self
    {
        return new self('Middo name cannot be empty.');
    }
}
