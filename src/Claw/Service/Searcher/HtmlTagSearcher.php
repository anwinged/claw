<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;


class HtmlTagSearcher implements SearcherInterface
{
    /**
     * @var string
     */
    private $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function find(string $content)
    {
        $doc = new \DOMDocument($content);
        $loadResult = $doc->loadHTML($content);

        if ($loadResult === false) {
            throw new \RuntimeException('Search error');
        }

        $nodes = $doc->getElementsByTagName($this->tag);

        $matches = [];

        foreach ($nodes as $node) {
            /** @var \DOMNode $node */
            $matches[] = $doc->saveHTML($node);
        }

        return $matches;
    }
}
