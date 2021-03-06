<?php

declare(strict_types=1);

namespace Claw\Config;

use Claw\Service\ErrorHandler;
use Claw\Service\PageLoader;
use Claw\Service\Router\RouteMatcher;
use Claw\Service\Router\Router;
use Claw\Service\SearcherFactory;
use Claw\Service\SearchProcessor;
use Claw\Service\SearchRequestFormHandler;
use Claw\Service\SearchRequestValidator;
use Claw\Service\SearchResultFactory;
use Claw\Service\SearchResultStorage;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Сервисы приложения.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['request'] = $container->factory(function () {
            return Request::createFromGlobals();
        });

        $container['response'] = $container->factory(function () {
            return new Response();
        });

        $container['routeMatcher'] = function () {
            return new RouteMatcher();
        };

        $container['router'] = function ($c) {
            return new Router($c['routeMatcher']);
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

        $container['errorHandler'] = function ($c) {
            return new ErrorHandler($c['renderer'], $c['error.view']);
        };

        $container['searchRequestValidator'] = function () {
            return new SearchRequestValidator();
        };

        $container['searchRequestFormHandler'] = function () {
            return new SearchRequestFormHandler();
        };

        $container['searcherFactory'] = function () {
            return new SearcherFactory();
        };

        $container['pageLoader'] = function () {
            return new PageLoader();
        };

        $container['pdo'] = function ($c) {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s',
                $c['db.host'],
                $c['db.port'],
                $c['db.name']
            );

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
    }
}
