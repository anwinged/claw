<?php

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Service\Searcher\SearcherInterface;

class SearchProcessor
{
    /**
     * @var SearcherFactory
     */
    private $searcherFactory;

    /**
     * @var PageLoader
     */
    private $pageLoader;

    public function __construct(SearcherFactory $searcherFactory, PageLoader $pageRetriever)
    {
        $this->searcherFactory = $searcherFactory;
        $this->pageLoader = $pageRetriever;
    }

    public function process(SearchRequest $searchRequest)
    {
        /** @var SearcherInterface $searcher */
        $searcher = $this->searcherFactory->createParser(
            $searchRequest->getType(),
            $searchRequest->getText()
        );

        $content = $this->pageLoader->getContent($searchRequest->getUrl());

        return $searcher->find($content);
    }
}
