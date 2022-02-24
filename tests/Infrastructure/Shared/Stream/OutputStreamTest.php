<?php

declare(strict_types=1);

namespace Test\Infrastructure\Shared\Stream;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Shared\Stream\OutputStream;

class OutputStreamTest extends TestCase
{
    public function testOutputStream()
    {
        $expectedOutput = 'Wow, such stream';
        $stream = fopen("php://memory", "rw");
        $outputStream = new OutputStream($stream);

        $this->assertNull($outputStream->output($expectedOutput));

        rewind($stream);
        $this->assertEquals($expectedOutput, stream_get_line($stream, 1024, PHP_EOL));
    }
}
