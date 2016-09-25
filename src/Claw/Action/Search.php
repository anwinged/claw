<?php

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Entity\SearchRequest;
use Claw\Form\SearchRequestForm;
use Claw\Service\SearchProcessor;
use Claw\Validator\SearchRequestValidator;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Search implements ActionInterface
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
     * @var SearchProcessor
     */
    private $searchProcessor;

    public function __construct(
        Request $request,
        Engine $renderer,
        SearchProcessor $searchProcessor
    ) {
        $this->request = $request;
        $this->renderer = $renderer;
        $this->searchProcessor = $searchProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): Response
    {
        $searchRequest = new SearchRequest();
        $searchRequestForm = new SearchRequestForm($searchRequest);
        $searchRequestForm->handle($this->request);
        $errors = [];
        $searchResult = null;
        $isAjaxRequest = $this->request->request->getBoolean('ajax', false);

        if ($searchRequestForm->isSubmit()) {
            $searchRequestValidator = new SearchRequestValidator($searchRequest);
            $errors = $searchRequestValidator->validate();
            if (!$errors) {
                /* @var SearchProcessor $searchProcessor */
                $searchResult = $this->searchProcessor->process($searchRequest);

                if ($isAjaxRequest) {
                    $content = $this->renderer->render('view', [
                        'searchResult' => $searchResult,
                    ]);

                    return new Response($content);
                }

                return new RedirectResponse('/view?id='.$searchResult->getId());
            }
        }

        $content = $this->renderer->render('search', [
            'searchRequest' => $searchRequest,
            'errors' => $errors,
        ]);

        return new Response($content);
    }
}
