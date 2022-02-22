<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\ValueObject\Tax;
use App\Domain\ValueObject\OperationOutcome;

final class OperationResult
{
    public function __construct(
        public Tax $value,
        public float $debt = 0
    ) {
    }

    public function toArray()
    {
        return [
            'value' => $this->value->toFloat(),
            'accumulated_loss' => $this->accumulatedLoss
        ];
    }
}
