<?php

namespace App\Http\Action;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Action class to be extended
 */
abstract class Action
{
    /**
     * Does nothing here
     */
    public function __construct(

    ) {
        
    }

    abstract public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface;
}