<?php

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchResult;

class SearchResultFactory
{
    public function create()
    {
        return new SearchResult();
    }

    public function createFromSearchRequest(SearchRequest $request)
    {
        $result = $this->create();
        $result->setUrl($request->getUrl());
        $result->setType($request->getType());
        $result->setText($request->getText());

        return $result;
    }
}
