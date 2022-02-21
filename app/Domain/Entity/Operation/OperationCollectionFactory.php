<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\ValueObject\OperationType;
use App\Domain\ValueObject\UnitCost;
use App\Domain\ValueObject\Quantity;

class OperationCollectionFactory
{
    public static function fromArray(array $data): OperationCollection
    {
        $collection = new OperationCollection();
        foreach ($data as $operation) {
            $collection->add(
                new Operation(
                    operation: OperationType::fromString($operation['operation']),
                    unitCost: UnitCost::fromFloat($operation['unit-cost']),
                    quantity: Quantity::fromInt($operation['quantity'])
                )
            );
        }

        return $collection;
    }
}
