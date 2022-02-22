<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exceptions\ValueObject\OperationOutcome\InvalidOperationOutcomeException;

class OperationOutcome
{
    public const PROFIT_OPERATION_OUTCOME = 'profit';
    public const LOSS_OPERATION_OUTCOME = 'loss';
    public const VALID_OPERATION_OUTCOMES = [
        self::PROFIT_OUTCOME,
        self::LOSS_OUTCOME
    ];
    private string $outcome;

    public function __construct(string $outcome)
    {
        if (!$this->isValid($outcome)) {
            throw new InvalidOperationOutcomeException(
                sprintf('Invalid operation outcome: %s', $outcome)
            );
        }

        $this->outcome = $outcome;
    }

    public static function fromString(string $outcome): self
    {
        return new self($outcome);
    }

    private function isValid(string $outcome): bool
    {
        return in_array($outcome, self::VALID_OPERATION_OUTCOMES);
    }

    public function toString(): string
    {
        return $this->outcome;
    }
}
