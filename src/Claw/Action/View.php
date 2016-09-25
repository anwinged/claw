<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 16:35.
 */

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Storage\SearchResultStorage;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class View implements ActionInterface
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
