<?php

namespace App\Http\Renderer;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;

/**
 * Used to render Twig templates in actions
 */
final class TwigRenderer
{
    private array $partials;

    public function __construct(
        private Twig $twig,
        array $partials
    ) {
        $this->partials = $partials;
    }

    /**
     * Used for rendering full-page templates
     *
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * 
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        return $this->twig->render($response, $template, $data);
    }

    /**
     * Used for rendering HTMX partial templates
     *
     * @param ResponseInterface $response
     * @param string $partialName
     * @param array $data
     * 
     * @return ResponseInterface
     */
    public function renderPartial(ResponseInterface $response, string $partialName, array $data = []): ResponseInterface
    {
        $partialTemplate = $this->checkIfPartialExists($partialName);

        return $this->twig->render($response, $partialTemplate, $data);
    }

    /**
     * Checks if a partial template exists in whitelist, returns an empty string if not found
     * 
     * TODO: Return an error/exception to be handled
     *
     * @param string $partialName
     * 
     * @return string
     */
    private function checkIfPartialExists(string $partialName): string
    {
        // Returns the full path of the partial template if it exists
        if(isset($this->partials[$partialName])) {
            return $this->partials[$partialName];
        }

        else return "";
    }
}