<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 14:33.
 */

namespace Claw\Service\Searcher;

class LinkSearcher extends HtmlTagSearcher
{
    const IMAGE_TAG = 'a';

    public function __construct()
    {
        parent::__construct(self::IMAGE_TAG);
    }
}
