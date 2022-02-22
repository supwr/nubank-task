<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exceptions\ValueObject\UnitCost\InvalidUnitCostException;

class UnitCost
{
    private float $unitCost;

    public function __construct(float $unitCost)
    {
        if (!$this->isValid($unitCost)) {
            throw new InvalidUnitCostException(
                sprintf('Invalid unit cost: %s', $unitCost)
            );
        }

        $this->unitCost = $unitCost;
    }

    public static function fromFloat(float $unitCost): self
    {
        return new self($unitCost);
    }

    private function isValid(float $unitCost): bool
    {
        return $unitCost > 0;
    }

    public function toFloat(): float
    {
        return $this->unitCost;
    }
}
