<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesController extends Controller {


    public function home(RequestInterface $request, ResponseInterface $response){
        $this->render($response,'pages/home.twig');
    }

    public function getContact(RequestInterface $request, ResponseInterface $response){
        $this->render($response, 'pages/contact.twig');
    }

    public function postContact(RequestInterface $request, ResponseInterface $response){
        $message = \Swift_Message::newInstance('Message de contact')
            ->setFrom([$request->getParam('email') => $request->getParam('name')])
            ->setTo('contact@test.fr')
            ->setBody("un email vous a été envoyé :
            {$request->getParam('content')}");
        $this->mailer->send($message);
        $this->redirect($response,'contact');
    }
}