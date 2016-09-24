<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 10:05
 */

namespace Claw\Controller;


use Claw\Entity\SearchRequest;
use Claw\Form\SearchRequestForm;
use Claw\Service\SearchProcessor;
use Claw\Validator\SearchRequestValidator;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function index(Request $request, Container $container)
    {
        $searchRequest = new SearchRequest();
        $searchRequestForm = new SearchRequestForm($searchRequest);
        $searchRequestForm->handle($request);
        $errors = [];
        $matches = [];

        if ($searchRequestForm->isSubmit()) {
            $searchRequestValidator = new SearchRequestValidator($searchRequest);
            $errors = $searchRequestValidator->validate();
            if (!$errors) {
                /** @var SearchProcessor $searchRequestProcessor */
                $searchRequestProcessor = $container['searchProcessor'];
                $matches = $searchRequestProcessor->process($searchRequest);
            }
        }

        $content = $container['renderer']->render('index', [
            'searchRequest' => $searchRequest,
            'errors' => $errors,
            'matches' => $matches,
        ]);

        return new Response($content);
    }
}
