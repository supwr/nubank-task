<?php

declare(strict_types=1);

namespace Test\Domain\Entity\Operation;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\OperationResult;
use App\Domain\ValueObject\Tax;
use App\Domain\Exceptions\ValueObject\Tax\InvalidTaxException;

/**
 * OperationResultTest
 */
class OperationResultTest extends TestCase
{
    /**
     * testValidOperationResultWithLoss
     *
     * @return void
     */
    public function testValidOperationResultWithLoss(): void
    {
        $operationResult = new OperationResult(
            Tax::fromFloat(100),
            10
        );

        $this->assertInstanceOf(OperationResult::class, $operationResult);
        $this->assertInstanceOf(Tax::class, $operationResult->value);
        $this->assertEquals(10, $operationResult->debt);
        $this->assertEquals(100, $operationResult->value->toFloat());
    }

    public function testValidOperationResultWithout(): void
    {
        $operationResult = new OperationResult(
            Tax::fromFloat(100)
        );

        $this->assertInstanceOf(OperationResult::class, $operationResult);
        $this->assertInstanceOf(Tax::class, $operationResult->value);
        $this->assertEquals(0, $operationResult->debt);
        $this->assertEquals(100, $operationResult->value->toFloat());
    }

    /**
     * testInvalidOperationResultException
     *
     * @return void
     */
    public function testInvalidOperationResultException(): void
    {
        $this->expectException(InvalidTaxException::class);

        $operationResult = new OperationResult(
            Tax::fromFloat(-15),
            10
        );
    }
}
