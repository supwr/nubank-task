<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

use App\Infrastructure\Console\OperationTaxCalculator;

(function () {
    require __DIR__ . '/bootstrap.php';

    $operationCalculator = $container->get(OperationTaxCalculator::class);
    $operationCalculator->run();
})();
