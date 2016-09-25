<?php

declare(strict_types=1);

namespace Claw;

use Claw\Action\Search;
use Claw\Action\Items;
use Claw\Action\View;
use Claw\Service\PageLoader;
use Claw\Service\Router\Router;
use Claw\Service\SearcherFactory;
use Claw\Service\SearchProcessor;
use Claw\Service\SearchResultFactory;
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

        try {
            $response = $this->process($request);
        } catch (\Exception $e) {
            $response = $this->handleException($e);
        }

        $response->prepare($request);
        $response->send();
    }

    private function process(Request $request)
    {
        $router = $this->container['router'];

        /** @var Router $router */
        $route = $router->findRoute($request);

        if (!$route) {
            throw new \RuntimeException(sprintf(
                'Route for %s not found',
                $request->getPathInfo()
            ));
        }

        $action = $route->getAction();

        if (!isset($this->container[$action])) {
            throw new \RuntimeException(sprintf(
                'Action "%s" not found in service container',
                $action
            ));
        }

        $actionService = $this->container[$action];

        if (!($actionService instanceof ActionInterface)) {
            throw new \RuntimeException(sprintf(
                'Action "%s" (%s) must implement ActionInterface',
                $action,
                get_class($actionService)
            ));
        }

        $response = $actionService->run();

        if (!($response instanceof Response)) {
            throw new \RuntimeException(sprintf(
                'Action "%s" (%s) must return Response object',
                $action,
                get_class($actionService)
            ));
        }

        return $response;
    }

    private function handleException(\Exception $e)
    {
        $renderer = $this->container['renderer'];

        return new Response(
            $renderer->render('exception', ['exception' => $e]),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    private static function initAppServices(Container $container)
    {
        $rootPath = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $sourcePath = $rootPath.DIRECTORY_SEPARATOR.'src';
        $webPath = $rootPath.DIRECTORY_SEPARATOR.'web';

        $container['appName'] = 'Claw';
        $container['rootPath'] = $rootPath;
        $container['sourcePath'] = $sourcePath;
        $container['webPath'] = $webPath;

        $container['db.host'] = 'localhost';
        $container['db.name'] = 'claw';
        $container['db.user'] = 'claw';
        $container['db.pass'] = 'claw';

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
            $engine->addData(['appName' => $c['appName']]);
            $engine->loadExtension(new Asset($c['webPath']));

            return $engine;
        };

        $container['searcherFactory'] = function () {
            return new SearcherFactory();
        };

        $container['pageLoader'] = function () {
            return new PageLoader();
        };

        $container['pdo'] = function ($c) {
            $dsn = sprintf('mysql:host=%s;dbname=%s', $c['db.host'], $c['db.name']);

            $opt = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ];

            return new \PDO($dsn, $c['db.user'], $c['db.pass'], $opt);
        };

        $container['searchResultStorage'] = function ($c) {
            return new SearchResultStorage($c['pdo']);
        };

        $container['searchResultFactory'] = function () {
            return new SearchResultFactory();
        };

        $container['searchProcessor'] = function ($c) {
            return new SearchProcessor(
                $c['searcherFactory'],
                $c['pageLoader'],
                $c['searchResultStorage'],
                $c['searchResultFactory']
            );
        };

        $container['search'] = function ($c) {
            return new Search($c['request'], $c['renderer'], $c['searchProcessor']);
        };

        $container['view'] = function ($c) {
            return new View($c['request'], $c['renderer'], $c['searchResultStorage']);
        };

        $container['items'] = function ($c) {
            return new Items($c['request'], $c['renderer'], $c['searchResultStorage']);
        };
    }
}
