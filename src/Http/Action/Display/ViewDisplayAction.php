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
        $data = [
            'client' => [
                'name' => $_ENV['CLIENT_LOCAL_NAME'],
                'ipAddress' => '10.58.64.100'
            ]
        ];

        return $this->renderer->render($response, '/display/canvas.twig', $data);
    }
}