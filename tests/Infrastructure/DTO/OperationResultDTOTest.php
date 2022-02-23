<?php

declare(strict_types=1);

namespace Test\Infrastructure\DTO;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\DTO\OperationResultDTO;

class OperationResultDTOTest extends TestCase
{
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
