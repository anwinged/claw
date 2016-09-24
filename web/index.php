<?php

require_once '../vendor/autoload.php';

$app = new Claw\App();

$app->get('^/$', '\Claw\Controller\Controller::index');

$app->post('^/$', '\Claw\Controller\Controller::index');

$app->respond();
