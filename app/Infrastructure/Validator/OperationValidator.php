<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

class OperationValidator extends AbstractValidator
{
    private array $operationKeys = [
        'operation',
        'unit-cost',
        'quantity'
    ];

    public function __construct(public array $operation)
    {
        $this->validate();
    }

    protected function validate(): void
    {
        array_walk($this->operationKeys, function ($key) {
            if (!array_key_exists($key, $this->operation)) {
                $this->addError($key, 'Field not found');
            }
        });
    }
}
