<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Content\GetContentAction;
use App\Http\Action\Display\ViewDisplayAction;

// TODO: Add CORS middleware to protect routes

return function(App $app) {
    
    $app->group('/display', function(RouteCollectorProxy $display) {
        $display->get('/view', ViewDisplayAction::class);
        $display->get('/content', GetContentAction::class);
    });
};