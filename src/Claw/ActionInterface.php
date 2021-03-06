<?php

declare(strict_types=1);

namespace Claw;

use Symfony\Component\HttpFoundation\Response;

interface ActionInterface
{
    /**
     * Выполняет действие и возвращает объект ответа.
     *
     * @return Response
     */
    public function run(): Response;
}
