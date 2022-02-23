<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\ValueObject\OperationType;
use App\Domain\ValueObject\UnitCost;
use App\Domain\ValueObject\Quantity;

/**
 * Operation
 */
final class Operation
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        public OperationType $operation,
        public UnitCost $unitCost,
        public Quantity $quantity
    ) {
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'operation' => $this->operation->toString(),
            'unit-cost' => $this->unitCost->toFloat(),
            'quantity' => $this->quantity->toInt()
        ];
    }
}
