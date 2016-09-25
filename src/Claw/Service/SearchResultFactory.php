<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchResult;

class SearchResultFactory
{
    public function create(): SearchResult
    {
        return new SearchResult();
    }

    public function createFromSearchRequest(SearchRequest $request): SearchResult
    {
        $result = $this->create();
        $result->setUrl($request->getUrl());
        $result->setType($request->getType());
        $result->setText($request->getText());

        return $result;
    }
}
