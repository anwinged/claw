<?php

declare(strict_types=1);

namespace Claw;

use Claw\Action\Index;
use Claw\Action\View;
use Claw\Service\PageLoader;
use Claw\Service\Router\Router;
use Claw\Service\SearcherFactory;
use Claw\Service\SearchProcessor;
use Claw\Storage\SearchResultStorage;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
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

    public function get($path, $action)
    {
        $this->route('GET', $path, $action);
    }

    public function post($path, $action)
    {
        $this->route('POST', $path, $action);
    }

    public function route($method, $path, $action)
    {
        $router = $this->container['router'];
        $router->registerRoute($method, $path, $action);
    }

    public function respond()
    {
        $request = $this->container['request'];
        $router = $this->container['router'];

        /** @var Router $router */
        $route = $router->findRoute($request);

        if (!$route) {
            $notFound = $this->container['notFoundResponse'];
            $notFound->prepare($request);
            $notFound->send();

            return;
        }

        $action = $route->getAction();

        if (!isset($this->container[$action])) {
            throw new \RuntimeException();
        }

        $actionService = $this->container[$action];

        if (!($actionService instanceof ActionInterface)) {
            throw new \RuntimeException();
        }

        $response = $actionService->run();

        if (!($response instanceof Response)) {
            throw new \Exception();
        }

        $response->prepare($request);
        $response->send();
    }

    private static function initAppServices(Container $container)
    {
        $rootPath = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $sourcePath = $rootPath.DIRECTORY_SEPARATOR.'src';
        $webPath = $rootPath.DIRECTORY_SEPARATOR.'web';

        $container['rootPath'] = $rootPath;
        $container['sourcePath'] = $sourcePath;
        $container['webPath'] = $webPath;

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
            $engine = new Engine($c['sourcePath']
                .DIRECTORY_SEPARATOR.'Claw'
                .DIRECTORY_SEPARATOR.'View'
            );
            $engine->loadExtension(new Asset($c['webPath']));

            return $engine;
        };

        $container['searcherFactory'] = function () {
            return new SearcherFactory();
        };

        $container['pageLoader'] = function () {
            return new PageLoader();
        };

        $container['searchResultStorage'] = function () {
            return new SearchResultStorage();
        };

        $container['searchProcessor'] = function ($c) {
            return new SearchProcessor($c['searcherFactory'], $c['pageLoader'], $c['searchResultStorage']);
        };

        $container['index'] = function ($c) {
            return new Index($c['request'], $c['renderer'], $c['searchProcessor']);
        };

        $container['view'] = function ($c) {
            return new View($c['request'], $c['renderer'], $c['searchResultStorage']);
        };
    }
}
