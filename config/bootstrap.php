<?php

declare(strict_types = 1);

use Slim\App;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$container = $containerBuilder->addDefinitions(__DIR__ . '/container.php')->build();

return $container->get(App::class);