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

    /**
     * @var SearchResultFactory
     */
    private $factory;

    public function __construct(
        SearcherFactory $searcherFactory,
        PageLoader $pageRetriever,
        SearchResultStorage $storage,
        SearchResultFactory $factory
    ) {
        $this->searcherFactory = $searcherFactory;
        $this->pageLoader = $pageRetriever;
        $this->storage = $storage;
        $this->factory = $factory;
    }

    /**
     * Обрабатывает запрос поиска и возвращает результат,
     * содержащий данные запроса и все найденные вхождения.
     *
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

        $searchResult = $this->factory->createFromSearchRequest($searchRequest);
        $searchResult->setMatches($searcher->find($content));

        $this->storage->insert($searchResult);

        return $searchResult;
    }
}
