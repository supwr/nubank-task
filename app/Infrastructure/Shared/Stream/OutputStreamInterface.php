<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Stream;

interface OutputStreamInterface
{
    public function output(string $prompt): void;
}
