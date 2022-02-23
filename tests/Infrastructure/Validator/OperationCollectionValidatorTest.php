<?php

declare(strict_types=1);

namespace Test\Infrastructure\Validator;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Validator\OperationCollectionValidator;

/**
 * OperationCollectionValidatorTest
 */
class OperationCollectionValidatorTest extends TestCase
{                
    /**
     * testValidOperationCollectionInput
     *
     * @return void
     */
    public function testValidOperationCollectionInput(): void
    {
        $validInput = [
            ['operation' => 'buy', 'unit-cost' => 10, 'quantity' => 100]
        ];
        $validator = new OperationCollectionValidator($validInput);        

        $this->assertFalse($validator->hasErrors());
    }
        
    /**
     * testInvalidOperationCollectionInput
     *
     * @return void
     */
    public function testInvalidOperationCollectionInput(): void
    {
        $validInput = [
            ['operation' => 'buy', 'unit-cost' => 30],
            ['unit-cost' => 10, 'quantity' => 100],
            ['operation' => 'sell', 'unit-cost' => 30, 'quantity' => 10]
        ];
        $validator = new OperationCollectionValidator($validInput);        

        $this->assertTrue($validator->hasErrors());
        $this->assertCount(2, $validator->getErrors());
    }
}
