<?php

declare(strict_types=1);

namespace Test\Infrastructure\Shared\Stream;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Shared\Stream\OutputStream;

class OutputStreamTest extends TestCase
{
    public function testOutputStream()
    {
        $outputStream = new OutputStream(fopen("php://memory", "rw"));

        $this->assertNull($outputStream->output(''));
    }
}
