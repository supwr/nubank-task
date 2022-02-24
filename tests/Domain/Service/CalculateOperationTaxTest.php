<?php

declare(strict_types=1);

namespace Test\Domain\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Service\CalculateOperationTax;
use App\Domain\Entity\Operation\Operation;
use App\Domain\Entity\Operation\OperationResult;
use App\Domain\ValueObject\{
    Tax,
    OperationType,
    UnitCost,
    Quantity
};

/**
 * CalculateOperationTaxTest
 */
class CalculateOperationTaxTest extends TestCase
{
    /**
     * testSuccessfulBuyOperationWithNoPreviousTaxCalc
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithNoPreviousTaxCalc()
    {
        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::BUY_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(100)
        );

        $calculator = new CalculateOperationTax($operation, null, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
    }

    /**
     * testSuccessfulBuyOperationWithPreviousTaxCalc
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithPreviousTaxCalc()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            0
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(15),
            Quantity::fromInt(50)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulBuyOperationWithPreviousTaxCalcAndLoss
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithPreviousTaxCalcAndLoss()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            0
        );

        $avgCost = 20;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(50)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(500, $result->debt);
    }

    /**
     * testSuccessfulBuyOperationWithPreviousTaxCalcAndProfit
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithPreviousTaxCalcAndProfit()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            0
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(20),
            Quantity::fromInt(5000)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(10000, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulBuyOperationWithPreviousTaxCalcNoProfitOrLoss
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithPreviousTaxCalcNoProfitOrLoss()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            0
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(5000)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulBuyOperationWithPreviousTaxCalcAndProfitAndPreviousLoss
     *
     * @return void
     */
    public function testSuccessfulBuyOperationWithPreviousTaxCalcAndProfitAndPreviousLoss()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            2000
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(20),
            Quantity::fromInt(5000)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(9600, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    public function testSuccessfulBuyOperationWithPreviousTaxCalcAndNoProfitAndPreviousLoss()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            2000
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(20),
            Quantity::fromInt(100)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }
}
