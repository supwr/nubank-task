<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exceptions\ValueObject\OperationType\InvalidOperationTypeException;

class OperationType
{
    public const SELL_OPERATION = 'sell';
    public const BUY_OPERATION = 'buy';
    public const VALID_OPERATION_TYPES = [
        self::SELL_OPERATION,
        self::BUY_OPERATION
    ];
    private string $type;

    public function __construct(string $type)
    {
        if (!$this->isValid($type)) {
            throw new InvalidOperationTypeException(
                sprintf('Invalid operation type: %s', $type)
            );
        }

        $this->type = $type;
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    private function isValid(string $type): bool
    {
        return in_array($type, self::VALID_OPERATION_TYPES);
    }

    public function toString(): string
    {
        return $this->type;
    }
}
