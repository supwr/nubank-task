<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Operation\{
    Operation,
    OperationResult
};
use App\Domain\ValueObject\{
    OperationType,
    Tax
};

/**
 * CalculateOperationTax
 */
class CalculateOperationTax
{
    private OperationResult $operationResult;
    private const OPERATION_COST_THRESHOLD = 20000;
    private const TAX_PERCENTAGE_OVER_PROFIT = 0.2; //20%

    public function __construct(
        private Operation $operation,
        private ?OperationResult $previousOperationResult,
        private float $averageCost
    ) {
        $this->calcTaxes();
    }
    
    /**
     * getTaxes
     *
     * @return OperationResult
     */
    public function getTaxes(): OperationResult
    {
        return $this->operationResult;
    }
    
    /**
     * calcTaxes
     *
     * @return void
     */
    private function calcTaxes(): void
    {
        $this->operationResult = new OperationResult(
            value: Tax::fromFloat(0),
            debt: 0
        );

        if (!$this->isSellOperation()) {
            $this->operationResult->debt += $this->previousOperationResult?->debt;
            return;
        }

        $variation = $this->getOperationCostVariation();
        if ($this->isLoss()) {
            $this->operationResult->debt = $variation + $this->previousOperationResult?->debt;
            return;
        }

        $profit = $variation - $this->previousOperationResult?->debt;
        if ($profit < 0) {
            $this->operationResult->debt = abs($profit);
            return;
        }

        if ($this->isTaxable()) {
            $this->operationResult->value = Tax::fromFloat(
                $profit * self::TAX_PERCENTAGE_OVER_PROFIT
            );
        }
    }
    
    /**
     * isSellOperation
     *
     * @return bool
     */
    private function isSellOperation(): bool
    {
        return $this->operation->operation->toString() == OperationType::SELL_OPERATION;
    }
    
    /**
     * isTaxable
     *
     * @return bool
     */
    private function isTaxable(): bool
    {
        return $this->operation->operation->toString() == OperationType::SELL_OPERATION && $this->getOperationCost() >= self::OPERATION_COST_THRESHOLD;
    }
    
    /**
     * getOperationCost
     *
     * @return float
     */
    private function getOperationCost(): float
    {
        return $this->operation->unitCost->toFloat() * $this->operation->quantity->toInt();
    }
    
    /**
     * getOperationCostVariation
     *
     * @return float
     */
    private function getOperationCostVariation(): float
    {
        return abs($this->averageCost - $this->operation->unitCost->toFloat()) * $this->operation->quantity->toInt();
    }
    
    /**
     * isLoss
     *
     * @return bool
     */
    private function isLoss(): bool
    {
        return $this->operation->unitCost->toFloat() < $this->averageCost;
    }
}
