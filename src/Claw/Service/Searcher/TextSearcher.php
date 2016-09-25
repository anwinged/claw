<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

/**
 * Поиск всех вхождений определенного текста.
 */
class TextSearcher extends RegexSearcher
{
    /**
     * @param string $text Подстрока для поиска
     */
    public function __construct(string $text)
    {
        $pattern = '/'.preg_quote($text, '/').'/';

        parent::__construct($pattern);
    }
}
