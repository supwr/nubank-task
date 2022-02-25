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
     * testSuccessfulSellOperationWithPreviousTaxCalc
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalc()
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
     * testSuccessfulSellOperationWithoutPreviousTaxCalcAndLoss
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithoutPreviousTaxCalcAndLoss()
    {
        $avgCost = 20;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(50)
        );

        $calculator = new CalculateOperationTax($operation, null, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(500, $result->debt);
    }

    /**
     * testSuccessfulSellOperationWithPreviousTaxCalcAndLoss
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndLoss()
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
     * testSuccessfulSellOperationWithPreviousTaxCalcAndProfit
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndProfit()
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
     * testSuccessfulSellOperationWithNoPreviousTaxCalcAnd20000Taxable
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithNoPreviousTaxCalcAnd20000Taxable()
    {
        $avgCost = 2;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(4),
            Quantity::fromInt(5000)
        );

        $calculator = new CalculateOperationTax($operation, null, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(2000, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulSellOperationWithPreviousTaxCalcNoProfitOrLoss
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcNoProfitOrLoss()
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
     * testSuccessfulSellOperationWithPreviousTaxCalcAndProfitAndPreviousLoss
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndProfitAndPreviousLoss()
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

    /**
     * testSuccessfulSellOperationWithPreviousTaxCalcAndNoProfitAndPreviousLoss
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndNoProfitAndPreviousLoss()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            1000
        );

        $avgCost = 10;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(10),
            Quantity::fromInt(200)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(1000, $result->debt);
    }

    /**
     * testSuccessfulSellOperationWithNoPreviousTaxCalcAnd20000OperationalCost
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithNoPreviousTaxCalcAnd20000OperationalCost()
    {
        $avgCost = 20;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(20),
            Quantity::fromInt(1000)
        );

        $calculator = new CalculateOperationTax($operation, null, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulSellOperationWithPreviousTaxCalcAndDebt
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndDebt()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            20000
        );

        $avgCost = 20;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(40),
            Quantity::fromInt(1000)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(0, $result->debt);
    }

    /**
     * testSuccessfulSellOperationWithPreviousTaxCalcAndGreaterDebt
     *
     * @return void
     */
    public function testSuccessfulSellOperationWithPreviousTaxCalcAndGreaterDebt()
    {
        $previousOperationResult = new OperationResult(
            Tax::fromFloat(0),
            30000
        );

        $avgCost = 20;
        $operation = new Operation(
            OperationType::fromString(OperationType::SELL_OPERATION),
            UnitCost::fromFloat(40),
            Quantity::fromInt(1000)
        );

        $calculator = new CalculateOperationTax($operation, $previousOperationResult, $avgCost);
        $result = $calculator->getTaxes();

        $this->assertNotEmpty($result->toArray());
        $this->assertEquals(0, $result->value->toFloat());
        $this->assertEquals(10000, $result->debt);
    }
}
