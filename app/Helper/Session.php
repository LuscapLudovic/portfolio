<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 12/03/2019
 * Time: 09:45
 */

namespace App\Helper;


class Session
{
    /**
     * @param $name
     * @return mixed
     * Il s'agit ici de récupérer la variable session en tant que variable qui puisse être appelé dans la vue twig
     */
    public function get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $_SESSION[$name];
    }

    /**
     * @param $name
     * @param $value
     * Il s'agit ici d'attribuer la valeur à la variable qui sera récupérer dans la vue.
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }
}