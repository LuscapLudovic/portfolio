<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class UserController extends Controller {

    public function newUser(RequestInterface $request, ResponseInterface $response){
        $errors = [];
        Validator::email()->validate($request->getParam('email')) || $errors['email'] = 'Votre email n\'est pas valide';
        Validator::notEmpty()->validate($request->getParam('login')) || $errors['login'] = 'Veuillez entrer votre login';
        Validator::notEmpty()->validate($request->getParam('mdp')) || $errors['mdp'] = 'Veuillez entrer un mot de passe';
        if(empty($errors)){
            $prepare = $this->pdo()->prepare('INSERT INTO users(login, email, mdp) VALUES'
            .'('.$request->getParam('login').','.$request->getParam('email').','.$request->getParam('mdp').')');
            $this->flash('Vous êtes bien inscrit');
            return $this->redirect($response, 'home');
        } else {
            $this->flash('Certains champs n\'ont pas été rempli correctement ', 'error');
            $this->flash($errors, 'errors');
            return $this->redirect($response,'incription', 400);
        }
    }

    public function testUser(){
        $prepare = $this->pdo()->prepare('SELECT * FROM  users');
        $prepare->execute();
        $repo = $prepare->fetchAll();
        var_dump($repo);
    }
}