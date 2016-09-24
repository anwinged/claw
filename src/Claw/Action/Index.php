<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 15:06
 */

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

class Index implements ActionInterface
{
    private $request;

    private $renderer;

    private $searchProcessor;

    public function __construct(
        Request $request,
        Engine $renderer,
        SearchProcessor $searchProcessor
    )
    {
        $this->request = $request;
        $this->renderer = $renderer;
        $this->searchProcessor = $searchProcessor;
    }

    public function run()
    {
        $searchRequest = new SearchRequest();
        $searchRequestForm = new SearchRequestForm($searchRequest);
        $searchRequestForm->handle($this->request);
        $errors = [];
        $searchResult = null;

        if ($searchRequestForm->isSubmit()) {
            $searchRequestValidator = new SearchRequestValidator($searchRequest);
            $errors = $searchRequestValidator->validate();
            if (!$errors) {
                /** @var SearchProcessor $searchProcessor */
                $searchResult = $this->searchProcessor->process($searchRequest);

                return new RedirectResponse('/view?id='.$searchResult->getId());
            }
        }

        $content = $this->renderer->render('index', [
            'searchRequest' => $searchRequest,
            'errors' => $errors,
            'matches' => $searchResult ? $searchResult->getMatches() : [],
        ]);

        return new Response($content);
    }
}
