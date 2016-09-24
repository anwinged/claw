<?php

require_once '../vendor/autoload.php';

$app = new Claw\App();

$app->get('^/$', 'index');
$app->post('^/$', 'index');

$app->get('^/index', 'index');
$app->post('^/index', 'index');

$app->get('^/view', 'view');
$app->get('^/items', 'items');

$app->respond();
