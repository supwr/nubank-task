<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\Entity\Operation\OperationResult;

final class OperationResultCollection
{
    private array $operationResults;

    public function __construct()
    {
        $this->operationResults = [];
    }

    public function add(OperationResult $operationResult): bool
    {
        $this->operationResults[] = $operationResult;
        return true;
    }

    public function has(OperationResult $operationResult): bool
    {
        return in_array($operationResult, $this->operationResults);
    }

    public function remove(OperationResult $operationResult): bool
    {
        if (!$this->has($operationResult)) {
            return false;
        }

        $key = array_search($operationResult, $this->operationResults);
        unset($this->operationResults[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->operationResults;
    }

    public function toArray(): array
    {
        return array_map(function (OperationResult $operationResult) {
            return $operationResult->toArray();
        }, $this->operationResults);
    }
}
