<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\SignpostAction;
use App\Http\Action\Auth\ViewLoginAction;
use App\Http\Action\Dashboard\ViewDashboardAction;
use App\Http\Action\Display\ViewDisplayAction;

// TODO: Add CORS middleware to protect routes

return function(App $app) {
    
    $app->get('/display', ViewDisplayAction::class);

};