<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 04/03/2019
 * Time: 15:12
 */

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class UserController extends Controller {
    public function newUser(){
        $prepare = $this->pdo()-prepare('');
    }

    public function testUser(){
        $prepare = $this->pdo()->prepare('SELECT * FROM  users');
        $prepare->execute();
        $repo = $prepare->fetchAll();
        var_dump($repo);
    }
}