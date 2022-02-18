<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';

use App\Infrastructure\Console\OperationTaxCalculator;

(function() {
    OperationTaxCalculator::run();
})();
