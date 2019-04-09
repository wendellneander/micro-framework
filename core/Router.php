<?php

namespace Core;


class Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->setRoutes($routes);

        $this->run();
    }

    private function run()
    {
        $url = $this->getUrl();

        $this->getRoute($url);
    }

    private function getRoute($url)
    {
        $urlArray = explode('/', $url);

        $found = false;

        foreach ($this->routes as $route) {
            $routeArray = explode('/', $route[0]);

            if (count($urlArray) !== count($routeArray)) {
                continue;
            }

            for ($i = 0; $i < count($routeArray); $i++) {

                if (strpos($routeArray[$i], '{') !== false) {

                    $routeArray[$i] = $urlArray[$i];

                    $params[] = $urlArray[$i];

                }

                $route[0] = implode($routeArray, '/');

            }

            if ($url == $route[0]) {
                $found = true;

                $controller = $route[1];

                $action = $route[2];

                break;
            } else {
                exit("route not founded");
                //TODO criar exception
            }
        }
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

    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}
