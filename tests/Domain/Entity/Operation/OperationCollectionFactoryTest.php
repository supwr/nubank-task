<?php

declare(strict_types=1);

namespace Test\Domain\Entity\Operation;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\{
    OperationCollection,
    OperationCollectionFactory,
    Operation
};
use App\Domain\Exceptions\ValueObject\OperationType\InvalidOperationTypeException;

/**
 * OperationCollectionFactoryTest
 */
class OperationCollectionFactoryTest extends TestCase
{
    /**
     * testValidOperationCollectionCreation
     *
     * @return void
     */
    public function testValidOperationCollectionCreation(): void
    {
        $collectionArray = [
            ['operation' => 'buy', 'unit-cost' => 10, 'quantity' => 100],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50]
        ];

        $collection = OperationCollectionFactory::fromArray($collectionArray);

        $this->assertInstanceOf(OperationCollection::class, $collection);
    }

    /**
     * testInvalidOperationCollectionException
     *
     * @return void
     */
    public function testInvalidOperationCollectionException(): void
    {
        $this->expectException(InvalidOperationTypeException::class);

        $collectionArray = [
            ['operation' => 'invalid-operation', 'unit-cost' => 10, 'quantity' => 100],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50]
        ];

        OperationCollectionFactory::fromArray($collectionArray);
    }
}
