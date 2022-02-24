<?php

declare(strict_types=1);

namespace Test\Infrastructure\Shared\Stream;

class MemoryStream
{    
    public static function setMemoryStream(string $expectedUserInput)
    {
        $input = fopen("php://memory","rw");
        fwrite($input, $expectedUserInput . PHP_EOL);
        rewind($input);

        return $input;
    }
}
