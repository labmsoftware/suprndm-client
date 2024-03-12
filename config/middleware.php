<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Odan\Session\Middleware\SessionStartMiddleware;

return function(App $app) {
    
    $app->addBodyParsingMiddleware();

    // TODO: TwigMiddleware

    // TODO: UserNetworkSessionDataMiddleware

    $app->add(SessionStartMiddleware::class);

    $app->addRoutingMiddleware();

    $app->add(BasePathMiddleware::class);
    
    $app->add(ErrorMiddleware::class);

};