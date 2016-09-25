<?php

declare(strict_types=1);

namespace Claw\Service;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchType;

class SearchRequestValidator
{
    public function validate(SearchRequest $searchRequest): array
    {
        $errors = [];

        $url = $searchRequest->getUrl();
        $type = $searchRequest->getType();
        $text = $searchRequest->getText();

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
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
