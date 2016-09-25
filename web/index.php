<?php

require_once '../vendor/autoload.php';

$app = new Claw\App();

$app->get('^/$', 'search');
$app->post('^/$', 'search');

$app->get('^/index$', 'search');
$app->post('^/index$', 'search');

$app->get('^/view(\?.+)?$', 'view');
$app->get('^/items(\?.+)?$', 'items');

$app->get('', 'not_found');
$app->post('', 'not_found');

$app->respond();
