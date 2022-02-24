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

        $buyOperationA = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(10000)
        );
        $buyOperationB = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(5000)
        );
        $buyOperationC = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(25),
            Quantity::fromInt(5000)
        );
        $sellOperationA = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(15),
            Quantity::fromInt(10000)
        );
        $sellOperationB = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(1)
        );

        $expectedCollectionAsArray = [
            [
                'operation' => 'buy',
                'unit-cost' => 10,
                'quantity' => 10000
            ],
            [
                'operation' => 'buy',
                'unit-cost' => 10,
                'quantity' => 5000
            ],
            [
                'operation' => 'buy',
                'unit-cost' => 25,
                'quantity' => 5000
            ],
            [
                'operation' => 'sell',
                'unit-cost' => 15,
                'quantity' => 10000
            ]
        ];

        $this->assertTrue($collection->add($buyOperationA));
        $this->assertTrue($collection->add($buyOperationB));
        $this->assertTrue($collection->add($buyOperationC));
        $this->assertTrue($collection->add($sellOperationA));
        $this->assertTrue($collection->add($sellOperationB));
        $this->assertTrue($collection->remove($sellOperationB));
        $this->assertCount(4, $collection->get());
        $this->assertTrue($collection->has($buyOperationA));
        $this->assertEquals($expectedCollectionAsArray, $collection->toArray());
        $this->assertFalse($collection->remove($sellOperationB));
        $this->assertEquals(13.75, $collection->getAvgPrice());
    }
}
