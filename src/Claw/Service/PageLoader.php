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
        $options = [
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => '',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_MAXREDIRS => 10,
        ];

        $handler = curl_init($url);

        if ($handler === false) {
            throw new \RuntimeException('CURL not initialized');
        }

        curl_setopt_array($handler, $options);

        $content = curl_exec($handler);
        $contentType = curl_getinfo($handler, CURLINFO_CONTENT_TYPE);
        $errorCode = curl_errno($handler);
        $errorMessage = curl_error($handler);

        curl_close($handler);

        if ($errorCode) {
            throw new \RuntimeException(sprintf(
                'CURL error [%s]: %s',
                $errorCode,
                $errorMessage
            ));
        }

        return $this->convertContent($content, $contentType);
    }

    /**
     * Convert page to UTF-8 encoding if possible.
     *
     * http://stackoverflow.com/a/2513938
     *
     * @param string $content
     * @param string $contentType
     *
     * @return string
     */
    private function convertContent(string $content, string $contentType)
    {
        unset($charset);

        /* 1: HTTP Content-Type: header */
        preg_match('@([\w/+]+)(;\s*charset=(\S+))?@i', $contentType, $matches);
        if (isset($matches[3])) {
            $charset = $matches[3];
        }

        /* 2: <meta> element in the page */
        if (!isset($charset)) {
            preg_match('@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s*charset=([^\s"]+))?@i', $content, $matches);
            if (isset($matches[3])) {
                $charset = $matches[3];
            }
        }

        /* 3: <xml> element in the page */
        if (!isset($charset)) {
            preg_match('@<\?xml.+encoding="([^\s"]+)@si', $content, $matches);
            if (isset($matches[1])) {
                $charset = $matches[1];
            }
        }

        /* 4: PHP's heuristic detection */
        if (!isset($charset)) {
            $encoding = mb_detect_encoding($content);
            if ($encoding) {
                $charset = $encoding;
            }
        }

        /* 5: Default for HTML */
        if (!isset($charset)) {
            if (strstr($contentType, 'text/html') === 0) {
                $charset = 'ISO 8859-1';
            }
        }

        /* Convert it if it is anything but UTF-8 */
        /* You can change "UTF-8"  to "UTF-8//IGNORE" to
           ignore conversion errors and still output something reasonable */
        if (isset($charset) && strtoupper($charset) != 'UTF-8') {
            $content = iconv($charset, 'UTF-8', $content);
        }

        return $content;
    }
}
