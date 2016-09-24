<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 12:21.
 */

namespace Claw\Form;

use Claw\Entity\SearchRequest;
use Symfony\Component\HttpFoundation\Request;

class SearchRequestForm
{
    private $searchRequest;

    private $submit = false;

    public function __construct(SearchRequest $searchRequest)
    {
        $this->searchRequest = $searchRequest;
    }

    public function handle(Request $request)
    {
        $this->submit = false;

        if ($request->request->has('url')) {
            $this->searchRequest->setUrl($request->request->get('url'));
            $this->submit = true;
        }

        if ($request->request->has('type')) {
            $this->searchRequest->setType($request->request->get('type'));
            $this->submit = true;
        }

        if ($request->request->has('text')) {
            $this->searchRequest->setText($request->request->get('text'));
            $this->submit = true;
        }
    }

    public function isSubmit()
    {
        return $this->submit;
    }
}
