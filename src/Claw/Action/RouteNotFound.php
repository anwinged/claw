<?php

namespace Claw\Action;

use Claw\ActionInterface;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

class RouteNotFound implements ActionInterface
{
    /**
     * @var Engine
     */
    private $renderer;

    public function __construct(Engine $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): Response
    {
        return new Response(
            $this->renderer->render('not_found', ['subject' => 'Страница']),
            Response::HTTP_NOT_FOUND
        );
    }
}
