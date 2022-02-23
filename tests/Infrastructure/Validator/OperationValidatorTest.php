<?php

declare(strict_types=1);

namespace Test\Infrastructure\Validator;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Validator\OperationValidator;

/**
 * OperationValidatorTest
 */
class OperationValidatorTest extends TestCase
{        
    /**
     * testValidOperationInput
     *
     * @return void
     */
    public function testValidOperationInput(): void
    {
        $validInput = ['operation' => 'buy', 'unit-cost' => 10, 'quantity' => 100];
        $validator = new OperationValidator($validInput);        

        $this->assertFalse($validator->hasErrors());
    }
    
    /**
     * testInvalidOperationInput
     *
     * @return void
     */
    public function testInvalidOperationInput(): void
    {
        $validInput = ['unit-cost' => 10, 'quantity' => 100];
        $validator = new OperationValidator($validInput);        

        $this->assertTrue($validator->hasErrors());
        $this->assertNotEmpty($validator->getErrors());
    }
}
