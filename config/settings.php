<?php

declare(strict_types = 1);

use Dotenv\Dotenv;

// Set APP_ENV if not already set
$_ENV['APP_ENV'] = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'dev';

Dotenv::createImmutable([__DIR__ . '/env/'], [$_ENV['APP_ENV'] . '.env'])->load();

return require __DIR__ . '/defaults.php';