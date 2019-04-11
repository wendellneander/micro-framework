<?php

namespace Core;

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;

class Bootstrap
{

    /**
     * @var Application $app
     */
    private $app;

    /**
     * @throws \ReflectionException
     */
    public function start()
    {
        $this->app();

        $this->dotenv();

        $this->database();

        $this->templateEngine();

        $this->router();
    }

    /**
     * @throws \ReflectionException
     */
    private function router()
    {
        $routes = require_once __DIR__ . '/../config/routes.php';

        $this->app->setRouter(new Router($routes));
    }

    private function database()
    {
        $this->app->setDatabase(DataBase::getInstance());
    }

    private function dotenv()
    {
        $dotenv = Dotenv::create(__DIR__ . '/..');

        $dotenv->load();
    }

    private function templateEngine()
    {
        $viewPath = __DIR__ . '/../views';

        $cachePath = __DIR__ . '/../storage/cache/views';

        $this->app->setTemplateEngine(new Blade([$viewPath], $cachePath));
    }

    private function app()
    {
        $this->app = new Application();
    }
}

