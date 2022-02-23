<?php

declare(strict_types=1);

namespace Test\Domain\Entity\Operation;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\{
    OperationCollection,
    Operation
};
use App\Domain\ValueObject\{
    OperationType,
    UnitCost,
    Quantity
};

/**
 * OperationCollectionTest
 */
class OperationCollectionTest extends TestCase
{
    /**
     * testValidOperationCollection
     *
     * @return void
     */
    public function testValidOperationCollection(): void
    {
        $collection = new OperationCollection();
        $buyOperation = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(1)
        );
        $sellOperation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(1)
        );

        $expectedCollectionAsArray = [
            [
                'operation' => 'buy',
                'unit-cost' => 10,
                'quantity' => 1
            ]
        ];

        $collection->add($buyOperation);
        $collection->add($sellOperation);
        $collection->remove($sellOperation);

        $this->assertCount(1, $collection->get());
        $this->assertTrue($collection->has($buyOperation));
        $this->assertEquals($expectedCollectionAsArray, $collection->toArray());
        $this->assertFalse($collection->remove($sellOperation));
        $this->assertEquals(10, $collection->getAvgPrice());
    }
}
