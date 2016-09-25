<?php

namespace Claw\Action;

use Claw\ActionInterface;
use Claw\Entity\SearchRequest;
use Claw\Service\SearchRequestFormHandler;
use Claw\Service\SearchProcessor;
use Claw\Service\SearchRequestValidator;
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
     * @var SearchRequestFormHandler
     */
    private $formHandler;

    /**
     * @var SearchRequestValidator
     */
    private $validator;

    /**
     * @var SearchProcessor
     */
    private $searchProcessor;

    public function __construct(
        Request $request,
        Engine $renderer,
        SearchRequestFormHandler $formHandler,
        SearchRequestValidator $validator,
        SearchProcessor $searchProcessor
    ) {
        $this->request = $request;
        $this->renderer = $renderer;
        $this->formHandler = $formHandler;
        $this->validator = $validator;
        $this->searchProcessor = $searchProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): Response
    {
        $searchRequest = new SearchRequest();
        $isSubmit = $this->formHandler->handle($searchRequest, $this->request);
        $errors = $isSubmit ? $this->validator->validate($searchRequest) : [];
        $isAjaxRequest = $this->request->request->getBoolean('ajax', false);

        $searchResult = null;

        if ($isSubmit && !$errors) {
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

        $content = $this->renderer->render('search', [
            'searchRequest' => $searchRequest,
            'errors' => $errors,
        ]);

        return new Response($content);
    }
}
