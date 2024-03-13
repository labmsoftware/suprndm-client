<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Content\GetContentAction;
use App\Http\Action\Display\ViewDisplayAction;
use App\Http\Action\Content\ContentStatusAction;
use App\Http\Action\Content\ContentUploadAction;
use App\Http\Action\Manage\ViewQuickActionsAction;
use App\Http\Action\Content\ViewContentUploadAction;

// TODO: Add CORS middleware to protect routes

return function(App $app) {
    
    $app->get('/', ViewDisplayAction::class);

    $app->group('/content', function(RouteCollectorProxy $content) {
        $content->get('/view', GetContentAction::class);
        $content->get('/upload', ViewContentUploadAction::class);
        $content->get('/status', ContentStatusAction::class);

        $content->post('/upload', ContentUploadAction::class);
    });

    $app->group('/manage', function(RouteCollectorProxy $manage) {
        $manage->get('/actions', ViewQuickActionsAction::class);
    });
};