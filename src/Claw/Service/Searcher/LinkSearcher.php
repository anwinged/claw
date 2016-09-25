<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 14:33.
 */

namespace Claw\Service\Searcher;

/**
 * Поиск элементов со ссылками вида <a></a>.
 */
class LinkSearcher extends RegexSearcher
{
    const LINK_PATTERN = '/<a[^>]+>.*<\/a>/iU';

    public function __construct()
    {
        parent::__construct(self::LINK_PATTERN);
    }
}
