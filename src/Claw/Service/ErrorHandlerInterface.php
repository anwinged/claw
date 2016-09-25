<?php

namespace Claw\Service;

use Symfony\Component\HttpFoundation\Response;

/**
 * Обработчик ошибок
 */
interface ErrorHandlerInterface
{
    /**
     * Обрабатывает возникшее исключение
     *
     * @param \Exception $e
     * @return Response
     */
    public function handle(\Exception $e);
}
