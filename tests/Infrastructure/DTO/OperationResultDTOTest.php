<?php

declare(strict_types=1);

namespace Test\Infrastructure\DTO;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\DTO\OperationResultDTO;

/**
 * OperationResultDTOTest
 */
class OperationResultDTOTest extends TestCase
{
    /**
     * testOperationResultDTOToArray
     *
     * @return void
     */
    public function testOperationResultDTOToArray(): void
    {
        $tax = 10.50;
        $expected = [
            'tax' => $tax
        ];

        $operationResultDTO = new OperationResultDTO($tax);

        $this->assertEquals(
            $expected,
            $operationResultDTO->toArray()
        );
    }
}
