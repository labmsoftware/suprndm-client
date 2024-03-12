<?php

declare(strict_types = 1);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('upload_max_filesize', '2000M');
ini_set('post_max_filesize', '2000M');

// Timezone - time() is timezone independent https://stackoverflow.com/a/36390811/9013718
date_default_timezone_set('Europe/London');
// Set default locale
setlocale(LC_ALL, 'en_GB.utf8', 'en_GB');

// Init settings var
$settings = [];

// Error handler
$settings['error'] = [
    // Should be set to false in production. When set to true, it will throw an ErrorException for notices and warnings.
    'display_error_details' => false,
    'log_errors' => true,
    'log_error_details' => true,
];

// Set false for production env
$settings['dev'] = $_ENV['APP_ENV'] ?? true;

// Project root dir (1 parent)
$settings['root_dir'] = dirname(__DIR__, 1);
define('ROOT_DIR', dirname(__DIR__, 1));

$settings['deployment'] = [
    'version' => $_ENV['APP_VERSION'],

    // TODO: Disable in prod
    'asset_path' => $settings['root_dir'] . '/public/assets',
];

// Twig settings
$settings['twig'] = [
    'debug' => $_ENV['APP_DEBUG'] ?? true,
    'cache' => __DIR__ . '/../var/cache/twig',
    'auto_reload' => true,
    'templates' => __DIR__ . '/../templates',
    'partials' => [
        'content' => '/content/view.twig'
    ]
];

$settings['public'] = [
    'app_name' => $_ENV['APP_NAME'],
    'email' => [
        'main_contact_address' => 'support@labmsoftware.com',
        'main_sender_address' => 'no-reply@labmsoftware.com',
        'main_sender_name' => 'SuprNDM',
    ],
];

$settings['security'] = [
    // Bool if login requests should be throttled
    'throttle_login' => false,
    // Bool if email requests should be throttled
    'throttle_email' => false,
    // Seconds in the past relevant for global, user and ip login and email request throttle
    // If 3600, the requests in the past hour will be evaluated and compared to the set thresholds below
    'timespan' => 3600,

    // Key = sent email amount for throttling to apply; value = delay in seconds or 'captcha'; Lowest to highest
    'login_throttle_rule' => [4 => 10, 9 => 120, 12 => 'captcha'],
    // Percentage of login requests that may be failures (threshold) in the past month
    'login_failure_percentage' => 20
];

// Session config
$settings['session'] = [
    'name' => 'suprndm-client',
    'lifetime' => 7200,
    'path' => null,
    'domain' => $_ENV['APP_URL'],
    'secure' => false,
    'httponly' => true,
    'cache_limiter' => 'nocache',
    'cookie_samesite' => 'Lax',
    'cookie_secure' => false
];

$settings['logger'] = [
    // Log file location
    'path' => $settings['root_dir'] . '/var/log',
    // Default log level
    'level' => \Monolog\Level::Debug,
];

return $settings;