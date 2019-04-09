<?php
namespace Core;

class Bootstrap {

    private $router;

    /**
     * @throws \Exception
     */
    public function start()
    {
        $routes = require_once __DIR__ . '/../config/routes.php';

        $this->router = new \Core\Router($routes);
    }

}

