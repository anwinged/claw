<?php

declare(strict_types=1);

namespace Claw\Service\Router;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var RouteMatcher
     */
    private $matcher;

    /**
     * @param RouteMatcher $matcher
     */
    public function __construct(RouteMatcher $matcher)
    {
        $this->matcher = $matcher;
    }

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
            if ($this->matcher->matches($route, $request)) {
                return $route;
            }
        }

        return null;
    }
}
