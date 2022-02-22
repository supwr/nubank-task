<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exceptions\ValueObject\Tax\InvalidTaxException;

class Tax
{
    private float $tax;

    public function __construct(float $tax)
    {
        if (!$this->isValid($tax)) {
            throw new InvalidTaxException(
                sprintf('Invalid tax value: %s', $tax)
            );
        }

        $this->tax = $tax;
    }

    public static function fromFloat(float $tax): self
    {
        return new self($tax);
    }

    private function isValid(float $tax): bool
    {
        return $tax >= 0;
    }

    public function toFloat(): float
    {
        return $this->tax;
    }
}
