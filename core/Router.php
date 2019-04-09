<?php

namespace Core;


class Router
{
    private $routes;
    private $controllerName;
    private $controller;
    private $action;
    private $params;

    /**
     * Router constructor.
     * @param array $routes
     * @throws \Exception
     */
    public function __construct(array $routes)
    {
        $this->setRoutes($routes);

        $this->run();
    }

    /**
     * @throws \Exception
     */
    private function run()
    {
        $url = $this->getUrl();

        $this->getRoute($url);

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
     * @throws \Exception
     */
    private function setController()
    {
        $this->controller = Container::newController($this->controllerName);

        $method = $this->action;

        $this->controller->$method(...$this->params);
    }
    /**
     * @param $url
     * @throws \Exception
     */
    private function getRoute($url)
    {
        $urlArray = explode('/', $url);

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

            if ($url == $route[0]) {

                $found = true;

                $this->controllerName = $route[1];

                $this->action = $route[2];

                $this->params = $params;

                break;

            }

        }

        if(!$found){
            throw new \Exception('Rota não encotrada');
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
