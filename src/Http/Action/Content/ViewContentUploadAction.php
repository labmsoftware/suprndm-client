<?php

namespace App\Http\Action\Content;

use App\Http\Action\Action;
use App\Http\Renderer\TwigRenderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ViewContentUploadAction extends Action
{
    public function __construct(
        private TwigRenderer $renderer
    ) {
        
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->renderer->render($response, '/content/upload.twig');
    }
}