<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

class ImageSearcher extends HtmlTagSearcher
{
    const IMAGE_TAG = 'img';

    public function __construct()
    {
        parent::__construct(self::IMAGE_TAG);
    }
}
