<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchType;
use Claw\Service\Searcher\ImageSearcher;
use Claw\Service\Searcher\LinkSearcher;
use Claw\Service\Searcher\SearcherInterface;
use Claw\Service\Searcher\TextSearcher;

class SearcherFactory
{
    /**
     * Создает объект для поиска вхождений подстроки по тексту.
     *
     * @param string      $searchType
     * @param string|null $text
     *
     * @return SearcherInterface
     */
    public function createSearcher(string $searchType, string $text = null): SearcherInterface
    {
        switch ($searchType) {
            case SearchType::LINK:
                return new LinkSearcher();

            case SearchType::IMAGE:
                return new ImageSearcher();

            case SearchType::TEXT:
                return new TextSearcher($text);
        }

        throw new \RuntimeException(sprintf(
            'Unknown search type %s',
            $searchType
        ));
    }
}
