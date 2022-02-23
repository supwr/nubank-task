<?php

declare(strict_types=1);

namespace App\Domain\Entity\Operation;

use App\Domain\Entity\Operation\OperationResult;

/**
 * OperationResultCollection
 */
final class OperationResultCollection
{
    private array $operationResults;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->operationResults = [];
    }

    /**
     * add
     *
     * @param  mixed $operationResult
     * @return bool
     */
    public function add(OperationResult $operationResult): bool
    {
        $this->operationResults[] = $operationResult;
        return true;
    }

    /**
     * has
     *
     * @param  mixed $operationResult
     * @return bool
     */
    public function has(OperationResult $operationResult): bool
    {
        return in_array($operationResult, $this->operationResults);
    }

    /**
     * remove
     *
     * @param  mixed $operationResult
     * @return bool
     */
    public function remove(OperationResult $operationResult): bool
    {
        if (!$this->has($operationResult)) {
            return false;
        }

        $key = array_search($operationResult, $this->operationResults);
        unset($this->operationResults[$key]);
        return true;
    }

    /**
     * get
     *
     * @return array
     */
    public function get(): array
    {
        return $this->operationResults;
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (OperationResult $operationResult) {
            return $operationResult->toArray();
        }, $this->operationResults);
    }
}
