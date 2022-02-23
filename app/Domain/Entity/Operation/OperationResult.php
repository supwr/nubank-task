<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\ValueObject\Tax;
use App\Domain\ValueObject\OperationOutcome;

/**
 * OperationResult
 */
final class OperationResult
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        public Tax $value,
        public float $debt = 0
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
            'value' => $this->value->toFloat(),
            'debt' => $this->debt
        ];
    }
}
