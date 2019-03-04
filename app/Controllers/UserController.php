<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class UserController extends Controller {

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function newUser(RequestInterface $request, ResponseInterface $response){
        $errors = [];
        Validator::email()->validate($request->getParam('email')) || $errors['email'] = 'Votre email n\'est pas valide';
        Validator::notEmpty()->validate($request->getParam('login')) || $errors['login'] = 'Veuillez entrer votre login';
        // si tu trouve une solution pour une regex sur le mdp t'es un génie mon kyky
        Validator::notEmpty()->validate($request->getParam('mdp')) || $errors['mdp'] = 'Veuillez entrer un mot de passe';
        // la fonction "flash" est dans le controller c'est juste un notif
        if(empty($errors)){
            $prepare = $this->pdo()->prepare('INSERT INTO users(login, email, mdp) VALUES'
            .'('.$request->getParam('login').','.$request->getParam('email').','.$request->getParam('mdp').')');
            $this->flash('Vous êtes bien inscrit');
            return $this->redirect($response, 'home');
        } else {
            $this->flash('Certains champs n\'ont pas été rempli correctement ', 'error');
            $this->flash($errors, 'errors');
            //si tu as une page blanche au redirect change le status à 200 ou enleve le tout court.
            return $this->redirect($response,'incription', 400);
        }
    }

    /**
     * c'est une fonction pour test si la connexion marche bien
     */
    public function testUser(){
        $prepare = $this->pdo()->prepare('SELECT * FROM  users');
        $prepare->execute();
        $repo = $prepare->fetchAll();
        var_dump($repo);
    }
}