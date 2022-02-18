<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

class Operation
{
    public function __construct(public string $name)
    {
    }
}
