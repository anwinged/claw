<?php

namespace Claw\Validator;

use Claw\Entity\SearchRequest;
use Claw\Entity\SearchType;

class SearchRequestValidator
{
    private $searchRequest;

    public function __construct(SearchRequest $searchRequest)
    {
        $this->searchRequest = $searchRequest;
    }

    public function validate()
    {
        $errors = [];

        $url = $this->searchRequest->getUrl();
        $type = $this->searchRequest->getType();
        $text = $this->searchRequest->getText();

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $errors['url'] = 'Адрес указан в неправильном формате';
        }

        if (in_array($type, SearchType::getAvailableTypes(), $strict = true) === false) {
            $errors['type'] = 'Недопустимый тип поиска';
        }

        if ($type === SearchType::TEXT && !$text) {
            $errors['text'] = 'При поиске текста нужно указать что искать';
        }

        return $errors;
    }
}
