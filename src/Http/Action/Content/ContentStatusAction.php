<?php

namespace App\Http\Action\Content;

use App\Http\Action\Action;
use App\Http\Action\NonBufferedBody;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ContentStatusAction extends Action
{
    public function __construct(

    ) {
        
    }

    /**
     * Send status updates via SSE to clients
     * 
     * !! Does not work, needs fixing
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $response->withBody(new NonBufferedBody())
                        ->withHeader('Content-Type', 'text/event-stream')
                        ->withHeader('Cache-Control', 'no-cache')
                        ->withHeader('HX-Refresh', 'true');
                
        $body = $response->getBody();

        // 1 is always true, so repeat the while loop forever (aka event-loop)
        while (1) {
            // Send named event
            $event = sprintf("sse:new_content");

            // Add a whitespace to the end
            $body->write($event . ' ');

            // break the loop if the client aborted the connection (closed the page)
            if (connection_aborted()) {
                break;
            }

            // sleep for 1 second before running the loop again
            sleep(1);
        }
    }
}