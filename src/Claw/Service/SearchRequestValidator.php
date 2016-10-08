<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchType;

class SearchRequestValidator
{
    /**
     * Шаблон для проверки URL.
     *
     * @link https://github.com/symfony/validator/blob/master/Constraints/UrlValidator.php
     */
    const URL_PATTERN = '~^
            (http|https)://                         # protocol
            (
                ([\pL\pN\pS-\.])+(\.?([\pL\pN]|xn\-\-[\pL\pN-]+)+\.?) # a domain name
                    |                                                 # or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}                    # an IP address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+|\?\S*|\#\S*)                   # a /, nothing, a / with something, a query or a fragment
        $~ixu';

    /**
     * Проверяет перенаддный запрос поиска.
     *
     * @param SearchRequest $searchRequest
     *
     * @return array
     */
    public function validate(SearchRequest $searchRequest): array
    {
        $errors = [];

        $url = $searchRequest->getUrl();
        $type = $searchRequest->getType();
        $text = $searchRequest->getText();

        if (!preg_match(self::URL_PATTERN, $url)) {
            $errors['url'] = 'Адрес указан в неправильном формате';
        }

        if (SearchType::isAvailable($type) === false) {
            $errors['type'] = 'Недопустимый тип поиска';
        }

        if ($type === SearchType::TEXT && !$text) {
            $errors['text'] = 'При поиске текста нужно указать что искать';
        }

        return $errors;
    }
}
