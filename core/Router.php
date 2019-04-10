<?php

namespace Core;

use ReflectionMethod;

class Router
{
    private $url;
    private $routes;
    private $controllerName;
    private $controller;
    private $action;
    private $params;
    private $request;

    /**
     * Router constructor.
     * @param array $routes
     * @throws \ReflectionException
     */
    public function __construct(array $routes)
    {
        $this->setRoutes($routes);

        $this->run();
    }

    /**
     * @throws \ReflectionException
     */
    private function run()
    {
        $this->request = new Request();

        $this->params = [];

        $this->url = $this->getUrl();

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
        $this->controller = Container::controller($this->controllerName);

        $method = $this->action;

        $reflection = new ReflectionMethod("Controllers\\" .$this->controllerName, $method);

        $methodParams = $reflection->getParameters();

        $firstParam = isset($methodParams[0]) && $methodParams[0] ? $methodParams[0] : null;

        if($firstParam && $firstParam->getType() == 'Core\Request') {
            array_unshift($this->params, $this->getRequest());
        }

        $this->params = $this->params ? $this->params : [];

        $this->controller->$method(...$this->params);
    }

    private function getRequest() {

        return $this->request;

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

                $this->params = $params;

                break;

            }

        }

        if(!$found){
            Container::pageNotFound();
        }
    }

    /**
     * @return mixed
     */
    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}
