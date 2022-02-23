<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Stream;

class InputStream implements InputStreamInterface
{
    public function __construct(private $stream)
    {
    }

    public function prompt(string $prompt): string
    {
        fwrite($this->stream, $prompt);
        return stream_get_line($this->stream, self::MAX_LINE_LENGTH, PHP_EOL);
    }
}
