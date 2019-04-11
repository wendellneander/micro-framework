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
     * @throws \ReflectionException
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;

            $routes = require_once __DIR__ . '/../config/routes.php';

            static::$instance->run($routes);
        }

        return static::$instance;
    }

    /**
     * @param array $routes
     * @throws \ReflectionException
     */
    private function run(array $routes)
    {
        $this->params = [];

        $this->url = $this->getUrl();

        $this->setRoutes($routes);

        $this->getRoute();

        $this->setController();
    }

    private function setRoutes(array $routes)
    {
        $newRoutes = [];

        foreach ($routes as $route) {

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

}
