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

        $inputStream = new InputStream(MemoryStream::setMemoryStream($expectedUserInput));

        $this->assertEquals($expectedUserInput, $inputStream->prompt(''));
    }
}
