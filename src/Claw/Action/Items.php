<?php

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Storage\SearchResultStorage;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Items.
 */
class Items implements ActionInterface
{
    private $request;

    private $renderer;

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

    public function run()
    {
        $searchResults = $this->storage->findAll();

        $content = $this->renderer->render('items', [
            'searchResults' => $searchResults,
        ]);

        return new Response($content);
    }
}
