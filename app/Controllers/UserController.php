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
    public function postInscription(RequestInterface $request, ResponseInterface $response){
        $errors = [];
        Validator::email()->validate($request->getParam('email')) || $errors['email'] = 'Votre email n\'est pas valide';
        Validator::notEmpty()->validate($request->getParam('login')) || $errors['login'] = 'Veuillez entrer votre login';
        Validator::notEmpty()->validate($request->getParam('mdp')) || $errors['mdp'] = 'Veuillez entrer un mot de passe';
        // la fonction "flash" est dans le controller c'est juste une notif
        if(empty($errors)){
            $prepare = $this->pdo()->prepare('INSERT INTO users(login, email, mdp) VALUES ("'.htmlspecialchars($request->getParam('login')).'", "'.$request->getParam('email').'", "'.htmlspecialchars($request->getParam('mdp')).'")');
            $req = $prepare->execute();
            $this->flash('Vous êtes bien inscrit');
            return $this->redirect($response, 'home');
        } else {
            // Message d'erreur lorsqu'un des champs n'est pas rempli correctement
            $this->flash('Certains champs n\'ont pas été rempli correctement ', 'error');
            $this->flash($errors, 'errors');
            //si tu as une page blanche au redirect change le status à 200 ou enleve le tout court.
            return $this->redirect($response,'incription', 400);
        }
    }
}