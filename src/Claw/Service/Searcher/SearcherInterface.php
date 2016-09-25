<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

interface SearcherInterface
{
    /**
     * Находит все необходимые совпадения внутри строки.
     *
     * @param string $content
     *
     * @return string[]
     */
    public function find(string $content): array;
}
