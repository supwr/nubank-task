<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

/**
 * AbstractValidator
 */
abstract class AbstractValidator
{
    protected array $errors = [];

    /**
     * hasErrors
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * addError
     *
     * @param  mixed $param
     * @param  mixed $message
     * @return void
     */
    protected function addError(string $param, string $message): void
    {
        $this->errors[] = sprintf('[ %s ] %s', $param, $message);
    }

    /**
     * validate
     *
     * @return void
     */
    abstract protected function validate(): void;
}
