<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Service\CalculateOperationTax;
use App\Domain\Entity\Operation\OperationCollection;
use App\Domain\Entity\Operation\OperationResultCollection;

/**
 * CalculateOperationCollectionTax
 */
class CalculateOperationCollectionTax
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * calculate
     *
     * @param  mixed $operationCollection
     * @return OperationResultCollection
     */
    public function calculate(OperationCollection $operationCollection): OperationResultCollection
    {
        $taxResult = null;
        $operationResultCollection = new OperationResultCollection();

        foreach ($operationCollection->get() as $operation) {
            $operationTax = new CalculateOperationTax(
                $operation,
                $taxResult,
                $operationCollection->getAvgPrice()
            );

            $taxResult = $operationTax->getTaxes();
            $operationResultCollection->add($taxResult);
        }

        return $operationResultCollection;
    }
}
