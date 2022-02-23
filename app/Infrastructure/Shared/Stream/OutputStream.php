<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Stream;

class OutputStream implements OutputStreamInterface
{
    public function __construct(private $stream)
    {
    }

    public function output(string $output): void
    {
        fwrite($this->stream, $output . PHP_EOL);
    }
}
