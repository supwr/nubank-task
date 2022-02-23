<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

/**
 * OperationResultCollectionDTO
 */
class OperationResultCollectionDTO
{
    /**
     * __construct
     *
     * @param  mixed $collection
     * @return void
     */
    public function __construct(private array $collection)
    {
    }

    public function toArray(): array
    {
        return array_map(
            function ($operationResult) {
                return (new OperationResultDTO($operationResult['value']))->toArray();
            },
            $this->collection
        );
    }
}
