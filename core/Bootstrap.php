<?php

namespace Core;

class Bootstrap
{

    private $router;

    /**
     * @throws \Exception
     */
    public function start()
    {
        $this->router();

        $this->database();
    }

    /**
     * @throws \ReflectionException
     */
    private function router()
    {
        $routes = require_once __DIR__ . '/../config/routes.php';

        $this->router = new \Core\Router($routes);
    }

    private function database()
    {
        //TODO start database connection
    }

}

