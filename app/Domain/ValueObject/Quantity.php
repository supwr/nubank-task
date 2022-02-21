<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exceptions\ValueObject\Quantity\InvalidQuantityException;

class Quantity
{
    private int $quantity;

    public function __construct(int $quantity)
    {
        if (!$this->isValid($quantity)) {
            throw new InvalidQuantityException(
                sprintf('Invalid quantity: %s', $quantity)
            );
        }

        $this->quantity = $quantity;
    }

    public static function fromInt(int $quantity): self
    {
        return new self($quantity);
    }

    private function isValid(int $quantity): bool
    {
        return $quantity > 0;
    }

    public function toInt(): int
    {
        return $this->quantity;
    }
}
