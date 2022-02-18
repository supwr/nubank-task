<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

require __DIR__ . '/bootstrap.php';

use App\Infrastructure\Console\OperationTaxCalculator;

(function () {
    OperationTaxCalculator::run();
})();
