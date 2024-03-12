<?php

use Slim\App;
use Monolog\Logger;
use Slim\Views\Twig;
use Odan\Session\PhpSession;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Odan\Session\SessionInterface;
use App\Domain\Handler\DefaultErrorHandler;
use App\Http\Renderer\TwigRenderer;
use Monolog\Formatter\LineFormatter;
use Slim\Middleware\ErrorMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Utility\Settings;
use Monolog\Handler\RotatingFileHandler;
use Odan\Session\SessionManagerInterface;
use Slim\Interfaces\RouteParserInterface;
use Selective\BasePath\BasePathMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

return [
    
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    Settings::class => function (ContainerInterface $container) {
        return new Settings($container->get('settings'));
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);
        // Register routes
        (require __DIR__ . '/routes.php')($app);

        // Register middleware
        (require __DIR__ . '/middleware.php')($app);

        return $app;
    },

    LoggerInterface::class => function (ContainerInterface $c) {
        $settings = ($c->get(Settings::class))->get('logger');

        $logger = new Logger('app');

        // When testing, 'test' value is true which means the monolog test handler should be used
        if (isset($settings['test']) && $settings['test'] === true) {
            return $logger->pushHandler(new \Monolog\Handler\TestHandler());
        }

        // Instantiate logger with rotating file handler
        $filename = sprintf('%s/app.log', $settings['path']);
        $level = $settings['level'];
        // With the RotatingFileHandler, a new log file is created every day
        $rotatingFileHandler = new RotatingFileHandler($filename, 0, $level, true, 0777);
        // The last "true" here tells monolog to remove empty []'s
        $rotatingFileHandler->setFormatter(new LineFormatter(null, 'Y m d H:i:s', false, true));

        return $logger->pushHandler($rotatingFileHandler);
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },

    ServerRequestFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },

    // For Responder
    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    ErrorMiddleware::class => function (ContainerInterface $c) {
        $settings = ($c->get(Settings::class))->get('error');
        $app = $c->get(App::class);

        $logger = $c->get(LoggerInterface::class);

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details'],
            $logger
        );

        $errorMiddleware->setDefaultErrorHandler(
            $c->get(DefaultErrorHandler::class)
        );

        return $errorMiddleware;
    },

    Twig::class => function(ContainerInterface $container) {
        $settings = ($container->get(Settings::class))->get('twig');

        $twig = Twig::create($settings['templates'], [
            'debug' => $settings['debug'],
            'cache' => $settings['cache'],
            'auto_reload' => $settings['auto_reload']
        ]);

        return $twig;

    },

    TwigRenderer::class => function(ContainerInterface $container) {
        $partialsWhitelist = [];

        return new TwigRenderer(
            $container->get(Twig::class),
            $partialsWhitelist
        );
    },

    SessionManagerInterface::class => function (ContainerInterface $container) {
        return $container->get(SessionInterface::class);
    },

    SessionInterface::class => function (ContainerInterface $c) {
        $settings = ($c->get(Settings::class))->get('session');

        return new PhpSession($settings);
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    }
];