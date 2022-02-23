<?php

declare(strict_types=1);

namespace Test\Infrastructure\DTO;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\DTO\OperationResultDTO;
use App\Infrastructure\DTO\OperationResultCollectionDTO;
use App\Domain\Entity\Operation\OperationResult;
use App\Domain\ValueObject\Tax;

/**
 * OperationResultCollectionDTOTest
 */
class OperationResultCollectionDTOTest extends TestCase
{
    /**
     * testOperationResultCollectionDTOToArray
     *
     * @return void
     */
    public function testOperationResultCollectionDTOToArray(): void
    {
        $collection = [
            (new OperationResult(
                Tax::fromFloat(10),
                0
            ))->toArray(),
            (new OperationResult(
                Tax::fromFloat(20),
                0
            ))->toArray(),
            (new OperationResult(
                Tax::fromFloat(30),
                0
            ))->toArray()
        ];

        $expected = [
            [
                'tax' => 10
            ],
            [
                'tax' => 20
            ],
            [
                'tax' => 30
            ]
        ];

        $operationResultCollectionDTO = new OperationResultCollectionDTO($collection);

        $this->assertEquals(
            $expected,
            $operationResultCollectionDTO->toArray()
        );
    }
}
