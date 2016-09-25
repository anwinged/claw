<?php

declare(strict_types=1);

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Service\SearchResultStorage;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Items.
 */
class Items implements ActionInterface
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
        $searchResults = $this->storage->findAll();

        $content = $this->renderer->render('items', [
            'searchResults' => $searchResults,
        ]);

        return new Response($content);
    }
}
