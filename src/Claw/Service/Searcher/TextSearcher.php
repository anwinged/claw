<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

class TextSearcher implements SearcherInterface
{
    /**
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function find(string $content)
    {
        $lastPos = 0;
        $positions = [];

        while (($lastPos = strpos($content, $this->text, $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($this->text);
        }

        return $positions;
    }
}
