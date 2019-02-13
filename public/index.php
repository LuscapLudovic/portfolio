<?php

use App\Controllers\PagesController;

require '../vendor/autoload.php';

session_start();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require('../app/container.php');

//Container

$container = $app->getContainer();

//MiddleWare

$app->add(new \App\MiddleWares\FlashMiddleWare($container->view->getEnvironment()));

$app->get('/', PagesController::class . ':home');
$app->get('/me-contacter', PagesController::class . ':getContact')->setName('contact');
$app->get('/projets', PagesController::class . ':getProjet')->setName('projet');
$app->post('/me-contacter', PagesController::class . ':postContact');
$app->get('/lien-externe',PagesController::class. ':lienExterne')->setName('lienExterne');
$app->run();