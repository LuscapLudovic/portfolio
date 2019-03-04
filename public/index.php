<?php

use App\Controllers\PagesController;
use App\Controllers\UserController;

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
$app->add(new \App\MiddleWares\OldMiddleWare($container->view->getEnvironment()));
$app->add(new \App\MiddleWares\TwigCsrfMiddleWare($container->view->getEnvironment(), $container->csrf));
$app->add($container->csrf);

//$app->get('/',UserController::class . ':testUser')->setName('home'); test de l'appel d'un user
$app->get('/', PagesController::class . ':home')->setName('home');
$app->get('/me-contacter', PagesController::class . ':getContact')->setName('contact');
$app->get('/projets', PagesController::class . ':getProjet')->setName('projet');
$app->get('/veille-techno', PagesController::class. ':getVeille')->setName('veille');
$app->post('/me-contacter', PagesController::class . ':postContact');
$app->get('/lien-externe',PagesController::class. ':lienExterne')->setName('lienExterne');
$app->run();