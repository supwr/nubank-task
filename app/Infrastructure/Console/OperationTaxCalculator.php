<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Entity\Operation\OperationCollectionFactory;
use App\Domain\ValueObject\OperationType;
use App\Infrastructure\Validator\OperationCollectionValidator;
use App\Infrastructure\Shared\Helper\JsonInputHelper;
use App\Application\Command\CalculateOperationCollectionTax;

class OperationTaxCalculator
{
    public function __construct(private CalculateOperationCollectionTax $taxCalculator)
    {
    }

    public function run()
    {
        $operations = [];

        while (!empty($input = readline("Enter your operation list: "))) {
            $operationCollection = JsonInputHelper::parseJson($input);

            $validator = new OperationCollectionValidator($operationCollection);

            if ($validator->hasErrors()) {
                fwrite(STDOUT, 'This collection structure is incorrect' . PHP_EOL);
                exit();
            }

            $o = OperationCollectionFactory::fromArray($operationCollection);
            $operations[] = $o;
        }

        foreach ($operations as $operation) {
            fwrite(STDOUT, json_encode($operation->getAvgPrice()) . PHP_EOL);
        }
        // fwrite(STDOUT, json_encode($operations) . PHP_EOL);
    }
}
