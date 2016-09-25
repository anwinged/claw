<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchResult;
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
    public function process(SearchRequest $searchRequest): SearchResult
    {
        /** @var SearcherInterface $searcher */
        $searcher = $this->searcherFactory->createSearcher(
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
