<?php

declare(strict_types=1);

namespace Claw;

use Claw\Config\ActionProvider;
use Claw\Config\ParameterProvider;
use Claw\Config\ServiceProvider;
use Claw\Service\ErrorHandlerInterface;
use Claw\Service\Router\Router;
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

        $rootPath = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $sourcePath = $rootPath.DIRECTORY_SEPARATOR.'src';
        $webPath = $rootPath.DIRECTORY_SEPARATOR.'web';

        $this->container['appName'] = 'Claw';
        $this->container['rootPath'] = $rootPath;
        $this->container['sourcePath'] = $sourcePath;
        $this->container['webPath'] = $webPath;

        (new ParameterProvider())->register($this->container);
        (new ServiceProvider())->register($this->container);
        (new ActionProvider())->register($this->container);
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
        $handler = $this->container['errorHandler'];

        if (!($handler instanceof ErrorHandlerInterface)) {
            throw new \RuntimeException(sprintf(
                'ErrorHandler (%s) must implement ErrorHandlerInterface',
                get_class($handler)
            ));
        }

        return $handler->handle($e);
    }
}
