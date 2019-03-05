<?php

namespace App\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface;

class Controller{
    private $container;

    /**
     * PagesController constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function pdo(){
        $pdo = new PDO('mysql:dbname=portfolio;host=localhost', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public function render(ResponseInterface $response, $file, $params = []){
        $this->container->view->render($response,$file, $params);
    }

    //fonction du controller pour la redirection
    public function redirect($response, $name, $status = 302){
        return $response->withStatus($status)->withHeader('Location', $this->router->pathFor($name));
    }

    public function flash($message, $type = 'success' ){
        if(!isset($_SESSION['flash'])){
            $_SESSION['flash'] = [];
        }
        return $_SESSION['flash'][$type] = $message;
    }
    public function __get($name)
    {
        return $this->container->get($name);
    }


}