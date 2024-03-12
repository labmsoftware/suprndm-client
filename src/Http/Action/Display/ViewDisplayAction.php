<?php

namespace App\Http\Action\Display;

use App\Http\Action\Action;
use App\Http\Renderer\TwigRenderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ViewDisplayAction extends Action
{
    public function __construct(
        protected TwigRenderer $renderer
    ) {
        
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->renderer->render($response, '/display/displa.twig');
    }
}