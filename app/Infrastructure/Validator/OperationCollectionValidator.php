<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

class OperationCollectionValidator extends AbstractValidator
{
    public function __construct(public array $operationCollection)
    {
        $this->validate();
    }

    protected function validate(): void
    {
        foreach ($this->operationCollection as $operation) {
            $operationValidator = new OperationValidator($operation);
            if ($operationValidator->hasErrors()) {
                $this->addError('operation', 'Wrong structure');
            }
        }
    }
}
