<?php

$container = $app->getContainer();

$container['debug'] = function(){
    return true;
};

$container['view'] = function ($container) {
    $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir. '/app/views', [
        'cache' => false//$dir.'/tmp/cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['mailer'] = function($container){
    if($container->debug){
        $transport = Swift_SmtpTransport::newInstance('localhost', 1025);
    } else {
        $transport = Swift_MailTransport::newInstance();
    }

  $mailer = SwiftMailer::newInstance($transport);
  return $mailer;
};