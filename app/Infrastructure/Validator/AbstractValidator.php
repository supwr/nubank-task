<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

abstract class AbstractValidator
{
    protected array $errors = [];

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function addError(string $param, string $message): void
    {
        $this->errors[] = sprintf('[ %s ] %s', $param, $message);
    }

    abstract protected function validate(): void;
}
