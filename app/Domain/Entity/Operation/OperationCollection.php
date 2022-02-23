<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\Entity\Operation\Operation;
use App\Domain\ValueObject\OperationType;

/**
 * OperationCollection
 */
final class OperationCollection
{
    private array $operations;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->operations = [];
        $this->aggregateBuyOperations = [];
    }
    
    /**
     * add
     *
     * @param  mixed $operation
     * @return bool
     */
    public function add(Operation $operation): bool
    {
        $this->operations[] = $operation;
        return true;
    }
    
    /**
     * has
     *
     * @param  mixed $operation
     * @return bool
     */
    public function has(Operation $operation): bool
    {
        return in_array($operation, $this->operations);
    }
    
    /**
     * remove
     *
     * @param  mixed $operation
     * @return bool
     */
    public function remove(Operation $operation): bool
    {
        if (!$this->has($operation)) {
            return false;
        }

        $key = array_search($operation, $this->operations);
        unset($this->operations[$key]);
        return true;
    }
    
    /**
     * get
     *
     * @return array
     */
    public function get(): array
    {
        return $this->operations;
    }


    /**
     * getOperationsByType
     *
     * @param  mixed $type
     * @return array
     */
    private function getOperationsByType(OperationType $type): array
    {
        return array_filter($this->operations, function ($operation) use ($type) {
            return $operation->operation == $type;
        });
    }

    /**
     * aggregateBuyOperations
     *
     * @param  mixed $operations
     * @return array
     */
    private function aggregateBuyOperations(array $operations): array
    {
        $aggregateBuyOperations = [];

        foreach ($operations as $operation) {
            $item = array_search($operation->unitCost->toFloat(), array_column($aggregateBuyOperations, 'price'));

            if ($item === false) {
                $aggregateBuyOperations[] = [
                    'price' => $operation->unitCost->toFloat(),
                    'quantity' => $operation->quantity->toInt()
                ];
                continue;
            }

            $aggregateBuyOperations[$item]['quantity'] += $operation->quantity->toInt();
        }

        return $aggregateBuyOperations;
    }

    /**
     * getAvgPrice
     *
     * @return float
     */
    public function getAvgPrice(): float
    {
        $buyOperations = $this->aggregateBuyOperations(
            $this->getOperationsByType(OperationType::fromString(OperationType::BUY_OPERATION))
        );

        $totalPrice = $this->calcAggregateItemTotalPrice($buyOperations);

        $calculatedBuyAggregate = $this->calcAggregate($totalPrice['items']);

        return $calculatedBuyAggregate / $totalPrice['total'];
    }


    /**
     * calcAggregate
     *
     * @param  mixed $calcAggregateItemTotalPrice
     * @return float
     */
    private function calcAggregate(array $calcAggregateItemTotalPrice): float
    {
        return array_reduce(
            $calcAggregateItemTotalPrice,
            function ($aggregateSum, $item) {
                return $aggregateSum += $item;
            },
            0
        );
    }


    /**
     * calcAggregateItemTotalPrice
     *
     * @param  mixed $operations
     * @return array
     */
    private function calcAggregateItemTotalPrice(array $operations): array
    {
        $total = 0;

        $calcTotalPrice = array_map(function ($operation) use (&$total) {
            $total += $operation['quantity'];
            return $operation['price'] * $operation['quantity'];
        }, $operations);

        return [
            'items' => $calcTotalPrice,
            'total' => $total
        ];
    }


    /**
     * toArray
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (Operation $operation) {
            return $operation->toArray();
        }, $this->operations);
    }
}
