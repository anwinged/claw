<?php

namespace Claw;

use Symfony\Component\HttpFoundation\Response;

interface ActionInterface
{
    /**
     * @return Response
     */
    public function run();
}
