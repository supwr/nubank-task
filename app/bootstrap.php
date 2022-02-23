<?php

use DI\ContainerBuilder;
use App\Infrastructure\Shared\Stream\{
    InputStream,
    InputStreamInterface,
    OutputStream,
    OutputStreamInterface
};

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 1));
}

require BASE_PATH . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    InputStreamInterface::class => new InputStream(STDIN),
    OutputStreamInterface::class => new OutputStream(STDOUT),
]);
$container = $containerBuilder->build();

return $container;
