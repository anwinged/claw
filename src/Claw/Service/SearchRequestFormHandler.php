<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Symfony\Component\HttpFoundation\Request;

class SearchRequestFormHandler
{
    public function handle(SearchRequest $searchRequest, Request $request): bool
    {
        $submit = false;

        if ($request->request->has('url')) {
            $searchRequest->setUrl($request->request->get('url'));
            $submit = true;
        }

        if ($request->request->has('type')) {
            $searchRequest->setType($request->request->get('type'));
            $submit = true;
        }

        if ($request->request->has('text')) {
            $searchRequest->setText($request->request->get('text'));
            $submit = true;
        }

        return $submit;
    }
}
