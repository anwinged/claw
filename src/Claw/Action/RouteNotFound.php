<?php

namespace Claw\Action;

use Claw\ActionInterface;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

class RouteNotFound implements ActionInterface
{
    private $renderer;

    public function __construct(Engine $renderer)
    {
        $this->renderer = $renderer;
    }

    public function run()
    {
        return new Response(
            $this->renderer->render('not_found', ['subject' => 'Страница']),
            Response::HTTP_NOT_FOUND
        );
    }
}
