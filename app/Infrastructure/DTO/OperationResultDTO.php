<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

/**
 * OperationResultDTO
 */
class OperationResultDTO
{
    /**
     * __construct
     *
     * @param  mixed $tax
     * @return void
     */
    public function __construct(private float $tax)
    {
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'tax' => $this->tax
        ];
    }
}
