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
     * testValidOperationResult
     *
     * @return void
     */
    public function testValidOperationResult(): void
    {
        $operationResult = new OperationResult(
            Tax::fromFloat(100),
            10
        );

        $this->assertInstanceOf(OperationResult::class, $operationResult);
        $this->assertInstanceOf(Tax::class, $operationResult->value);
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
