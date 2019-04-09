<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:23
 */

namespace Core;


class Container
{
    /**
     * @param $controller
     * @return mixed
     * @throws \Exception
     */
    public static function newController($controller)
    {
        $controllerClass = "Controllers\\" . $controller;

        if(!class_exists($controllerClass)){
            throw new \Exception('Controller não encontrado');
        }

        return new $controllerClass;
    }
}
