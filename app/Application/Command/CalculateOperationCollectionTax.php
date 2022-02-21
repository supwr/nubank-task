<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Service\CalculateOperationTax;

class CalculateOperationCollectionTax
{
    public function __construct(private CalculateOperationTax $operationTax)
    {
    }

    public function calculate()
    {
        return $this->taxCalculator->calculate();
    }
}
