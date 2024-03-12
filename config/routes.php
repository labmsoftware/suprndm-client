<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Content\GetContentAction;
use App\Http\Action\Display\ViewDisplayAction;
use App\Http\Action\Content\ContentUploadAction;
use App\Http\Action\Content\ViewContentUploadAction;

// TODO: Add CORS middleware to protect routes

return function(App $app) {
    
    $app->get('', ViewDisplayAction::class);

    $app->group('/content', function(RouteCollectorProxy $content) {
        $content->get('/view', GetContentAction::class);
        $content->get('/upload', ViewContentUploadAction::class);

        $content->post('/upload', ContentUploadAction::class);
    });
};