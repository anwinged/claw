<?php

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchResult;
use Claw\Service\Searcher\SearcherInterface;
use Claw\Storage\SearchResultStorage;

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

    /**
     * @var SearchResultStorage
     */
    private $storage;

    public function __construct(
        SearcherFactory $searcherFactory,
        PageLoader $pageRetriever,
        SearchResultStorage $storage
    ) {
        $this->searcherFactory = $searcherFactory;
        $this->pageLoader = $pageRetriever;
        $this->storage = $storage;
    }

    /**
     * @param SearchRequest $searchRequest
     *
     * @return SearchResult
     */
    public function process(SearchRequest $searchRequest)
    {
        /** @var SearcherInterface $searcher */
        $searcher = $this->searcherFactory->createParser(
            $searchRequest->getType(),
            $searchRequest->getText()
        );

        $content = $this->pageLoader->getContent($searchRequest->getUrl());

        $searchResult = new SearchResult();
        $searchResult->setUrl($searchRequest->getUrl());
        $searchResult->setType($searchRequest->getType());
        $searchResult->setText($searchRequest->getText());
        $searchResult->setMatches($searcher->find($content));

        $this->storage->insert($searchResult);

        return $searchResult;
    }
}
