<?php

namespace Claw;

use Claw\Service\Router\Router;
use League\Plates\Engine;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->container = new Container();
        self::initAppServices($this->container);
    }

    public function get($path, callable $callback)
    {
        $this->route('GET', $path, $callback);
    }

    public function post($path, callable $callback)
    {
        $this->route('POST', $path, $callback);
    }

    public function route($method, $path, callable $callback)
    {
        $router = $this->container['router'];
        $router->registerRoute($method, $path, $callback);
    }

    public function respond()
    {
        $request = $this->container['request'];
        $response = $this->container['response'];
        $router = $this->container['router'];

        /** @var Router $router */
        $route = $router->findRoute($request);

        if (!$route) {
            $notFound = $this->container['notFoundResponse'];
            $notFound->prepare($request);
            $notFound->send();

            return;
        }

        $callback = $route->getCallback();
        $response = call_user_func($callback, $request, $response, $this->container);

        if (!($response instanceof Response)) {
            throw new \Exception();
        }

        $response->prepare($request);
        $response->send();
    }

    private static function initAppServices(Container $container)
    {
        $rootPath = realpath(__DIR__);

        $container['rootPath'] = $rootPath;

        $container['request'] = $container->factory(function () {
            return Request::createFromGlobals();
        });

        $container['response'] = $container->factory(function () {
            return new Response();
        });

        $container['notFoundResponse'] = $container->factory(function ($c) {
            /** @var Response $response */
            $response = $c['response'];
            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            return $response;
        });

        $container['router'] = function () {
            return new Router();
        };

        $container['renderer'] = function ($c) {
            return new Engine($c['rootPath'].DIRECTORY_SEPARATOR.'View');
        };
    }
}
