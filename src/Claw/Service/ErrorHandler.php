<?php

namespace Claw\Service;

use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var Engine
     */
    private $renderer;

    /**
     * @var string
     */
    private $view;

    public function __construct(Engine $renderer, string $view)
    {
        $this->renderer = $renderer;
        $this->view = $view;
    }

    public function handle(\Exception $e): Response
    {
        return new Response(
            $this->renderer->render($this->view, ['exception' => $e]),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
