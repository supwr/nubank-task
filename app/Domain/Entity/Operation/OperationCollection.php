<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\Entity\Operation\Operation;

final class OperationCollection
{
    private array $operations;

    public function __construct()
    {
        $this->operations = [];
    }

    public function add(Operation $operation): bool
    {
        if ($this->has($operation)) {
            return false;
        }

        $this->operations[] = $operation;
        return true;
    }

    public function has(Operation $operation): bool
    {
        return in_array($operation, $this->operations);
    }

    public function remove(Operation $operation): bool
    {
        if (!$this->has($operation)) {
            return false;
        }

        $key = array_search($operation, $this->operations);
        unset($this->operations[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->operations;
    }
}
