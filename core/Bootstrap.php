<?php

namespace Core;

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
        echo 'database';
        $this->database();
        echo 'blade';

        $this->templateEngine();
        echo 'router';
        $this->router();
        echo 'ok';
    }

    /**
     * @throws \ReflectionException
     */
    private function router()
    {
        Router::getInstance()->run();
    }

    private function database()
    {
        DataBase::getInstance()->run();
    }

    private function templateEngine()
    {
        Blade::getInstance();
    }
}

