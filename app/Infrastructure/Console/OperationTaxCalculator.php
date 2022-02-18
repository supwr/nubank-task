<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Entity\Operation;
use App\Domain\ValueObject\OperationType;
use App\Infrastructure\Validator\OperationCollectionValidator;

class OperationTaxCalculator
{
    public static function run()
    {
        $operations = [];

        while (!empty($input = readline("Enter your operation list: "))) {
            $collection = json_decode(
                $input,
                true
            );

            $validator = new OperationCollectionValidator($collection);

            if ($validator->hasErrors()) {
                fwrite(STDOUT, 'This collection structure is incorrect' . PHP_EOL);
                exit();
            }

            $operations[] = $input;
        }

        fwrite(STDOUT, json_encode($operations) . PHP_EOL);
    }
}
