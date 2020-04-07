<?php

namespace Core;

use ReflectionMethod;

class Router
{
    /**
     * @var $instance self
     */
    private static $instance;

    /**
     * @var $url string
     */
    private $url;

    /**
     * @var $routes array
     */
    private $routes;

    /**
     * @var $controllerName string
     */
    private $controllerName;

    /**
     * @var $controller string
     */
    private $controller;

    /**
     * @var $action string
     */
    private $action;

    /**
     * @var $params array
     */
    private $params;

    /**
     * @return Router
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
    public static function run()
    {
        self::getInstance()->params = [];

        self::getInstance()->url = self::getInstance()->getUrl();

        self::getInstance()->clearFlashSession();

        self::getInstance()->setRoutes();

        self::getInstance()->getRoute();

        self::getInstance()->setController();
    }

    public function route($path, $controller)
    {
        $this->routes[] = [$path, $controller];

        return $this;
    }

    private function setRoutes()
    {
        $newRoutes = [];

        foreach ($this->routes as $route) {

            $routeArray = explode('@', $route[1]);

            $newRoute = [$route[0], $routeArray[0], $routeArray[1]];

            $newRoutes[] = $newRoute;

        }

        $this->routes = $newRoutes;
    }

    /**
     * @throws \ReflectionException
     */
    private function setController()
    {
        $this->controller = Container::getInstance()->getController(
            $this->controllerName,
            $this->params
        );

        $method = $this->action;

        $reflection = new ReflectionMethod("Controllers\\" .$this->controllerName, $method);

        $methodParams = $reflection->getParameters();

        $firstParam = isset($methodParams[0]) && $methodParams[0] ? $methodParams[0] : null;

        if($firstParam && $firstParam->getType() == 'Core\Request') {
            array_unshift($this->params, Request::getInstance());
        }

        $this->params = $this->params ? $this->params : [];

        $this->controller->$method(...$this->params);
    }

    private function getRoute()
    {
        $urlArray = explode('/', $this->url);

        $found = false;

        foreach ($this->routes as $route) {
            $routeArray = explode('/', $route[0]);

            if (count($urlArray) !== count($routeArray)) {
                continue;
            }

            $params = null;

            for ($i = 0; $i < count($routeArray); $i++) {

                if (strpos($routeArray[$i], '{') !== false) {

                    $routeArray[$i] = $urlArray[$i];

                    $params[] = $urlArray[$i];

                }

                $route[0] = implode($routeArray, '/');

            }

            if ($this->url == $route[0]) {

                $found = true;

                $this->controllerName = $route[1];

                $this->action = $route[2];

                $this->params = is_array($params) ? $params : [];

                break;

            }

        }

        if(!$found){
            exit('Page not found');
        }
    }

    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function clearFlashSession()
    {
        Session::clearFlashes();
    }

}
