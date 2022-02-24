<?php

declare(strict_types=1);

namespace Test\Infrastructure\Console;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Console\OperationTaxCalculator;
use App\Application\Command\CalculateOperationCollectionTax;
use App\Domain\Entity\Operation\{
    OperationResultCollection,
    OperationResult
};
use App\Infrastructure\Shared\Stream\{
    InputStream,
    OutputStream
};
use App\Domain\ValueObject\Tax;
use Mockery;

/**
 * OperationTaxCalculatorTest
 */
class OperationTaxCalculatorTest extends TestCase
{
    /**
     * testSuccessfulRun
     *
     * @return void
     */
    public function testSuccessfulRun(): void
    {
        $calculateOperationCollectionTax = Mockery::mock(CalculateOperationCollectionTax::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('calculate')
                ->once()
                ->andReturn($this->mockOperationResultCollection());
        });

        $mockInputStream = Mockery::mock(InputStream::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('prompt')
                ->twice()
                ->andReturn(
                    '[{"operation":"buy", "unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell", "unit-cost":15, "quantity": 50}]',
                    ''
                );
        });

        $mockOutputStream = Mockery::mock(OutputStream::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('output')
                ->once()
                ->with('[{"tax":10},{"tax":0}]');
        });

        $calculator = new OperationTaxCalculator(
            $calculateOperationCollectionTax,
            $mockInputStream,
            $mockOutputStream
        );

        $this->assertEmpty($calculator->run());
    }

    /**
     * testExceptionRun
     *
     * @return void
     */
    public function testExceptionRun(): void
    {
        $calculateOperationCollectionTax = Mockery::mock(CalculateOperationCollectionTax::class);

        $mockInputStream = Mockery::mock(InputStream::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('prompt')
                ->once()
                ->andReturn(
                    '[{"unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell"}]'
                );
        });

        $mockOutputStream = Mockery::mock(OutputStream::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('output')
                ->once()
                ->with('This collection structure is incorrect');
        });

        $calculator = new OperationTaxCalculator(
            $calculateOperationCollectionTax,
            $mockInputStream,
            $mockOutputStream
        );

        $this->assertEmpty($calculator->run());
    }

    /**
     * mockOperationResultCollection
     *
     * @return OperationResultCollection
     */
    private function mockOperationResultCollection(): OperationResultCollection
    {
        $collection = new OperationResultCollection();

        $collection->add(new OperationResult(Tax::fromFloat(10), 0));
        $collection->add(new OperationResult(Tax::fromFloat(0), 300));

        return $collection;
    }
}
