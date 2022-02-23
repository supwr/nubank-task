<?php

declare(strict_types=1);

namespace Test\Infrastructure\Shared\Helper;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Shared\Helper\JsonInputHelper;
use App\Infrastructure\Exceptions\Shared\Helper\InvalidJsonInputException;

/**
 * JsonInputHelperTest
 */
class JsonInputHelperTest extends TestCase
{    
    /**
     * testParseValidJson
     *
     * @return void
     */
    public function testParseValidJson(): void
    {
        $validJson = '[{"operation":"buy", "unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell", "unit-cost":15, "quantity": 50}]';
        $parsedData = JsonInputHelper::parseJson($validJson);

        $this->assertIsArray($parsedData);
        $this->assertCount(3, $parsedData);
    }
    
    /**
     * testParseInvalidJson
     *
     * @return void
     */
    public function testParseInvalidJson(): void
    {
        $this->expectException(InvalidJsonInputException::class);

        $validJson = 'not json';
        $parsedData = JsonInputHelper::parseJson($validJson);
    }
}
