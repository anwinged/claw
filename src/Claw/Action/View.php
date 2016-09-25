<?php

declare(strict_types=1);

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Service\SearchResultStorage;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class View implements ActionInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Engine
     */
    private $renderer;

    /**
     * @var SearchResultStorage
     */
    private $storage;

    public function __construct(
        Request $request,
        Engine $renderer,
        SearchResultStorage $storage
    ) {
        $this->request = $request;
        $this->renderer = $renderer;
        $this->storage = $storage;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): Response
    {
        $searchResult = $this->storage->find($this->request->query->getInt('id'));

        if (!$searchResult) {
            return new Response(
                $this->renderer->render('not_found', ['subject' => 'Запись']),
                Response::HTTP_NOT_FOUND
            );
        }

        $content = $this->renderer->render('view', [
            'searchResult' => $searchResult,
        ]);

        return new Response($content);
    }
}
