<?php

namespace Claw\Service\Searcher;

/**
 * Поиск совпадений внутри строки по регулярному выражению.
 */
class RegexSearcher implements SearcherInterface
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $content): array
    {
        $matches = [];

        $result = preg_match_all($this->pattern, $content, $matches);

        if ($result === false) {
            throw new \RuntimeException();
        }

        return $matches[0];
    }
}
