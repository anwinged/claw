<?php

namespace Claw\Service;

use Claw\Entity\SearchRequestType;
use Claw\Service\Searcher\ImageSearcher;
use Claw\Service\Searcher\LinkSearcher;
use Claw\Service\Searcher\SearcherInterface;
use Claw\Service\Searcher\TextSearcher;

class SearcherFactory
{
    /**
     * @param $searchType
     * @param string|null $text
     *
     * @return SearcherInterface
     */
    public function createParser($searchType, $text = null)
    {
        switch ($searchType) {
            case SearchRequestType::LINK:
                return new LinkSearcher();

            case SearchRequestType::IMAGE:
                return new ImageSearcher();

            case SearchRequestType::TEXT:
                return new TextSearcher($text);
        }

        throw new \RuntimeException(sprintf('Unknown search type %s', $searchType));
    }
}
