<?php

declare(strict_types=1);

namespace Test\Application\Command;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\{
    OperationCollectionFactory,
    OperationResultCollection
};
use App\Application\Command\CalculateOperationCollectionTax;

/**
 * CalculateOperationCollectionTaxTest
 */
class CalculateOperationCollectionTaxTest extends TestCase
{
    /**
     * testCalculateOperationCollection
     *
     * @return void
     */
    public function testCalculateOperationCollection()
    {
        $collectionArray = [
            ['operation' => 'buy', 'unit-cost' => 10, 'quantity' => 100],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50],
            ['operation' => 'sell', 'unit-cost' => 15, 'quantity' => 50]
        ];

        $calculator = new CalculateOperationCollectionTax();
        $result = $calculator->calculate(OperationCollectionFactory::fromArray($collectionArray));

        $this->assertInstanceOf(OperationResultCollection::class, $result);
        $this->assertCount(3, $result->get());
    }
}
