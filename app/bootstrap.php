<?php

use DI\ContainerBuilder;

define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

return $container;
