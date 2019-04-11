<?php

namespace Core;

use Dotenv\Dotenv;

class Bootstrap
{
    /**
     * @var $instance self
     */
    private static $instance;

    /**
     * @return Bootstrap
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @throws \ReflectionException
     */
    public function start()
    {
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
        Router::getInstance();
    }

    private function database()
    {
        DataBase::getInstance();
    }

    private function dotenv()
    {
        $dotenv = Dotenv::create(__DIR__ . '/..');

        $dotenv->load();
    }

    private function templateEngine()
    {
        \Core\Blade::getInstance();
    }
}

