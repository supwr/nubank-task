<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Service\CalculateOperationTax;
use App\Domain\Entity\Operation\OperationCollection;

class CalculateOperationCollectionTax
{
    public function __construct()
    {
    }

    public function calculate(OperationCollection $operationCollection)
    {
        $taxResult = null;
        $result = [];
        foreach ($operationCollection->get() as $operation) {
            $operationTax = new CalculateOperationTax(
                $operation,
                $taxResult,
                $operationCollection->getAvgPrice()
            );
            $taxResult = $operationTax->getTaxes();
            $result[] = [
                'tax' => $taxResult->value->toFloat()
            ];
        }

        fwrite(STDOUT, json_encode($result) . PHP_EOL);

        // return $this->taxCalculator->calculate();
    }
}
