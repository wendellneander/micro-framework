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
     */
    public static function newController($controller)
    {
        $controllerClass = "Controllers\\" . $controller;

        if(!class_exists($controllerClass)){
            exit('Controller not found');
        }

        return new $controllerClass;
    }

    public static function pageNotFound()
    {
        if(file_exists(__DIR__ . '/../views/404.php')){
            require_once __DIR__ . '/../views/404.php';

            exit;
        }else{
            exit('Page not found');
        }
    }

}
