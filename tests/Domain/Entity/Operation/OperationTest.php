<?php

declare(strict_types=1);

namespace Test\Domain\Entity\Operation;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Operation\Operation;
use App\Domain\ValueObject\OperationType;
use App\Domain\ValueObject\UnitCost;
use App\Domain\ValueObject\Quantity;
use App\Domain\Exceptions\ValueObject\OperationType\InvalidOperationTypeException;
use App\Domain\Exceptions\ValueObject\UnitCost\InvalidUnitCostException;
use App\Domain\Exceptions\ValueObject\Quantity\InvalidQuantityException;

/**
 * OperationTest
 */
class OperationTest extends TestCase
{
    /**
     * testValidOperation
     *
     * @return void
     */
    public function testValidOperation(): void
    {
        $operation = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(1)
        );

        $this->assertInstanceOf(Operation::class, $operation);
        $this->assertInstanceOf(OperationType::class, $operation->operation);
        $this->assertInstanceOf(UnitCost::class, $operation->unitCost);
        $this->assertInstanceOf(Quantity::class, $operation->quantity);
    }

    /**
     * testOperationWithInvalidOperationException
     *
     * @return void
     */
    public function testOperationWithInvalidOperationException(): void
    {
        $this->expectException(InvalidOperationTypeException::class);

        $operation = new Operation(
            OperationType::fromString('Invalid operation'),
            UnitCost::fromFloat(10),
            Quantity::fromInt(1)
        );
    }

    /**
     * testOperationWithInvalidUnitCostException
     *
     * @return void
     */
    public function testOperationWithInvalidUnitCostException(): void
    {
        $this->expectException(InvalidUnitCostException::class);

        $operation = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(-10),
            Quantity::fromInt(1)
        );
    }

    /**
     * testOperationWithInvalidQuantityException
     *
     * @return void
     */
    public function testOperationWithInvalidQuantityException(): void
    {
        $this->expectException(InvalidQuantityException::class);

        $operation = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(0)
        );
    }
}
