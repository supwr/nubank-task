<?php

declare(strict_types=1);

namespace Test\Domain\Entity\Operation;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\{
    OperationResultCollection,
    OperationResult
};
use App\Domain\ValueObject\Tax;

/**
 * OperationResultCollectionTest
 */
class OperationResultCollectionTest extends TestCase
{        
    /**
     * testValidOperationResultCollection
     *
     * @return void
     */
    public function testValidOperationResultCollection(): void
    {
        $collection = new OperationResultCollection();
        $firstOperationResult = new OperationResult(
            Tax::fromFloat(10),
            0
        );
        $secondOperation = new OperationResult(
            Tax::fromFloat(0),
            300
        );

        $expectedCollectionAsArray = [
            [
                'value' => 10,
                'debt' => 0
            ]
        ];

        $collection->add($firstOperationResult);
        $collection->add($secondOperation);
        $collection->remove($secondOperation);

        $this->assertCount(1, $collection->get());
        $this->assertTrue($collection->has($firstOperationResult));
        $this->assertEquals($expectedCollectionAsArray, $collection->toArray());  
        $this->assertFalse($collection->remove($secondOperation));      
    }
}
