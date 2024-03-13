<?php

namespace App\Http\Action\Manage;

use App\Http\Action\Action;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class RebootServerAction extends Action
{
    public function __construct(

    ) {
        
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        exec('sudo /sbin/reboot');

        $response->getBody()->write('Device reboot has started.');

        return $response;
    }
}