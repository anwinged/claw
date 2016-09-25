<?php

declare(strict_types=1);

namespace Claw\Service\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher;

class RouteMatcher
{
    /**
     * Сравнивает маршрут и запрос, определяя,
     * подхоит ли указанный маршрут для этого запроса.
     *
     * @param Route   $route
     * @param Request $request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request): bool
    {
        $requestMatcher = new RequestMatcher();
        $requestMatcher->matchMethod([$route->getMethod()]);
        $requestMatcher->matchPath($route->getPath());

        return $requestMatcher->matches($request);
    }
}
