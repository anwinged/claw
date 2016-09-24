<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

interface SearcherInterface
{
    /**
     * @param string $content
     *
     * @return \string[]
     */
    public function find(string $content);
}
