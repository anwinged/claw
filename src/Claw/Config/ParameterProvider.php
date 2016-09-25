<?php

namespace Claw\Config;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Список параметров приложения.
 */
class ParameterProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['db.host'] = 'localhost';
        $container['db.port'] = '3306';
        $container['db.name'] = 'claw';
        $container['db.user'] = 'claw';
        $container['db.pass'] = 'claw';

        $container['error.view'] = 'exception';
    }
}
