<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Stream;

interface InputStreamInterface
{
    public const MAX_LINE_LENGTH = 1024;

    public function prompt(string $prompt): string|bool;
}
