<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 13:16.
 */

namespace Claw\Service;

class PageLoader
{
    /**
     * @param $url
     *
     * @return string
     */
    public function getContent($url)
    {
        return file_get_contents($url);
    }
}
