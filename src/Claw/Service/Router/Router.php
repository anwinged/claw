<?php

declare(strict_types=1);

namespace Claw\Service\Router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher;

class Router
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @param string $method
     * @param string $path
     * @param string $action
     */
    public function registerRoute(string $method, string $path, string $action)
    {
        $this->routes[] = new Route($method, $path, $action);
    }

    /**
     * @param Request $request
     *
     * @return null|Route
     */
    public function findRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($this->matches($request, $route)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param Request $request
     * @param Route   $route
     *
     * @return bool
     */
    private function matches(Request $request, Route $route)
    {
        $requestMatcher = new RequestMatcher();
        $requestMatcher->matchMethod([$route->getMethod()]);
        $requestMatcher->matchPath($route->getPath());

        return $requestMatcher->matches($request);
    }
}
