<?php

declare(strict_types=1);

namespace Test\Infrastructure\Shared\Stream;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Shared\Stream\InputStream;

/**
 * InputStreamTest
 */
class InputStreamTest extends TestCase
{
    /**
     * testInputStream
     *
     * @return void
     */
    public function testInputStream()
    {
        $expectedUserInput = 'User input rules!';

        $stream = fopen("php://memory", "rw");

        $inputStream = new InputStream($stream);
        $inputStream->prompt($expectedUserInput);
        rewind($stream);

        $this->assertEquals($expectedUserInput, stream_get_line($stream, 1024, PHP_EOL));
    }
}
