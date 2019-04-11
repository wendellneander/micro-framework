<?php

namespace Core;

use Dotenv\Dotenv;

class Bootstrap
{
    /**
     * @var Router $router
     */
    private $router;

    /**
     * Bootstrap constructor.
     * @throws \ReflectionException
     */
    public function start()
    {
        $this->dotenv();

        $this->router();

        $this->database();
    }

    /**
     * @throws \ReflectionException
     */
    private function router()
    {
        $routes = require_once __DIR__ . '/../config/routes.php';

        $this->router = new Router($routes);
    }

    private function database()
    {
        //TODO start database connection
    }

    private function dotenv()
    {
        $dotenv = Dotenv::create(__DIR__);

        $dotenv->load();
    }
}

