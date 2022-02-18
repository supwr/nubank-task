<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Entity\Operation;
use App\Domain\ValueObject\OperationType;

class OperationTaxCalculator
{
    public static function run()
    {
        $lista = [];

        while(!empty($line = readline("Command: "))) {
            $lista[] = $line;
        }

        fwrite(STDOUT, json_encode($lista).PHP_EOL);
    }
}
