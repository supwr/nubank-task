<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

class OperationResultCollectionDTO
{
    public function __construct(private array $collection)
    {
    }

    public function toArray()
    {
        return array_map(
            function ($operationResult) {
                return (new OperationResultDTO($operationResult['value']))->toArray();
            },
            $this->collection
        );
    }
}
