<?php
/**
 * Created by PhpStorm.
 * User: av
 * Date: 24.09.16
 * Time: 10:05
 */

namespace Claw\Controller;


use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function index(Request $request, Response $response, Container $container)
    {
        $content = $container['renderer']->render('index', ['name' => 'World']);
        return $response->setContent($content);
    }
}