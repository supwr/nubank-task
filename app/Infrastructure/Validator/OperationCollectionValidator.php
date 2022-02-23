<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

/**
 * OperationCollectionValidator
 */
class OperationCollectionValidator extends AbstractValidator
{
    /**
     * __construct
     *
     * @param  mixed $operationCollection
     * @return void
     */
    public function __construct(public array $operationCollection)
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
        foreach ($this->operationCollection as $operation) {
            $operationValidator = new OperationValidator($operation);
            if ($operationValidator->hasErrors()) {
                $this->addError('operation', 'Wrong structure');
            }
        }
    }
}
