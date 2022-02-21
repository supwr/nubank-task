<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\Entity\Operation\Operation;
use App\Domain\ValueObject\OperationType;

final class OperationCollection
{
    private array $operations;
    private array $aggregateBuyOperations;

    public function __construct()
    {
        $this->operations = [];
        $this->aggregateBuyOperations = [];
    }

    public function add(Operation $operation): bool
    {
        $this->operations[] = $operation;
        $this->addToBuyAggregate($operation);
        return true;
    }

    public function has(Operation $operation): bool
    {
        return in_array($operation, $this->operations);
    }

    public function remove(Operation $operation): bool
    {
        if (!$this->has($operation)) {
            return false;
        }

        $key = array_search($operation, $this->operations);
        unset($this->operations[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->operations;
    }

    private function getOperationsByType(OperationType $type): array
    {
        return array_filter($this->operations, function ($operation) use ($type) {
            return $operation->operation == $type;
        });
    }

    private function addToBuyAggregate(Operation $operation): void
    {
        if ($operation->operation != OperationType::fromString(OperationType::BUY_OPERATION)) {
            return;
        }

        $item = array_search($operation->unitCost->toFloat(), array_column($this->aggregateBuyOperations, 'price'));

        if ($item === false) {
            $this->aggregateBuyOperations[] = [
                'price' => $operation->unitCost->toFloat(),
                'quantity' => $operation->quantity->toInt()
            ];
            return;
        }

        $this->aggregateBuyOperations[$item]['quantity'] += $operation->quantity->toInt();
    }

    public function getAvgPrice()
    {
        $total = 0;

        $calcTotalPrice = array_map(function ($operation) use (&$total) {
            $total += $operation['quantity'];
            return $operation['price'] * $operation['quantity'];
        }, $this->aggregateBuyOperations);

        $calculatedBuyAggregate = array_reduce($calcTotalPrice,
            function ($aggregateSum, $item) {
                return $aggregateSum += $item;
            },
            0
        );

        return $calculatedBuyAggregate / $total;
    }

    public function toArray()
    {
        return array_map(function (Operation $operation) {
            return $operation->toArray();
        }, $this->operations);
    }
}
