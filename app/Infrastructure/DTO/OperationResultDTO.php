<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

class OperationResultDTO
{
    public function __construct(private float $tax)
    {
    }

    public function toArray()
    {
        return [
            'tax' => $this->tax
        ];
    }
}
