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

    public function getTaxes(): OperationResult
    {
        return $this->operationResult;
    }

    private function calcTaxes()
    {
        $this->operationResult = new OperationResult(
            value: Tax::fromFloat(0),
            debt: 0
        );

        if ($this->isSellOperation() && $this->isLoss()) {
            $this->operationResult->debt = $this->previousOperationResult?->debt + $this->getUnitCostVariation();
            return;
        }

        if (!$this->isTaxable()) {
            return;
        }

        $profit = $this->getUnitCostVariation() - $this->previousOperationResult?->debt;

        if ($profit <= 0) {
            $this->operationResult->debt = abs($profit);
            $this->operationResult->value = Tax::fromFloat(0);
            return;
        }

        $this->operationResult->debt = 0;
        $this->operationResult->value = Tax::fromFloat($profit * self::TAX_PERCENTAGE_OVER_PROFIT);
    }

    private function isSellOperation(): bool
    {
        return $this->operation->operation->toString() == OperationType::SELL_OPERATION;
    }

    private function isTaxable(): bool
    {
        return $this->operation->operation->toString() == OperationType::SELL_OPERATION && $this->getOperationCost() >= self::OPERATION_COST_THRESHOLD;
    }

    private function getOperationCost(): float
    {
        return $this->operation->unitCost->toFloat() * $this->operation->quantity->toInt();
    }

    private function getUnitCostVariation(): float
    {
        return abs($this->averageCost - $this->operation->unitCost->toFloat()) * $this->operation->quantity->toInt();
    }

    private function isLoss(): bool
    {
        return $this->operation->unitCost->toFloat() < $this->averageCost;
    }

    private function isProfit(): bool
    {
        return $this->operation->unitCost->toFloat() > $this->averageCost;
    }
}
