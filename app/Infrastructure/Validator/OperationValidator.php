<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

/**
 * OperationValidator
 */
class OperationValidator extends AbstractValidator
{
    private array $operationKeys = [
        'operation',
        'unit-cost',
        'quantity'
    ];

    /**
     * __construct
     *
     * @param  mixed $operation
     * @return void
     */
    public function __construct(public array $operation)
    {
        $this->validate();
    }

    /**
     * validate
     *
     * @return void
     */
    protected function validate(): void
    {
        array_walk($this->operationKeys, function ($key) {
            if (!array_key_exists($key, $this->operation)) {
                $this->addError($key, 'Field not found');
            }
        });
    }
}
