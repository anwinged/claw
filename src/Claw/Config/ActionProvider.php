<?php

declare(strict_types=1);

namespace Claw\Config;

use Claw\Action\Items;
use Claw\Action\NotFound;
use Claw\Action\Search;
use Claw\Action\View;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Контроллеры приложения.
 */
class ActionProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['search'] = function ($c) {
            return new Search(
                $c['request'],
                $c['renderer'],
                $c['searchRequestFormHandler'],
                $c['searchRequestValidator'],
                $c['searchProcessor']
            );
        };

        $container['view'] = function ($c) {
            return new View($c['request'], $c['renderer'], $c['searchResultStorage']);
        };

        $container['items'] = function ($c) {
            return new Items($c['request'], $c['renderer'], $c['searchResultStorage']);
        };

        $container['not_found'] = function ($c) {
            return new NotFound($c['renderer']);
        };
    }
}
