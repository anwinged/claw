<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

/**
 * Поиск элеменов изображений вида <img>.
 */
class ImageSearcher extends RegexSearcher
{
    const IMAGE_PATTERN = '/<img[^>]+>/i';

    public function __construct()
    {
        parent::__construct(self::IMAGE_PATTERN);
    }
}
