<?php

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
     * @param callable $callable
     */
    public function registerRoute($method, $path, callable $callable)
    {
        $this->routes[] = new Route($method, $path, $callable);
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
