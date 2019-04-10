<?php
/**
 * Created by PhpStorm.
 * User: Wendell
 * Date: 08/04/2019
 * Time: 23:23
 */

namespace Core;

use ReflectionClass;
use ReflectionParameter;

class Container
{
    private static $instance;

    private $aliases;

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        static::$instance->loadAliases();

        return static::$instance;
    }

    private function loadAliases() {
        $aliases = require_once __DIR__ . '/../config/app.php';

        $this->aliases = isset($aliases['aliases']) ? $aliases['aliases'] : [];
    }

    /**
     * @param $abstract
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function make($abstract, $parameters = [])
    {
        $concrete = $this->getAlias($abstract);

        return $this->build($concrete, $parameters);
    }

    /**
     * @param $concrete
     * @param $parameters
     * @return object
     * @throws \ReflectionException
     */
    private function build($concrete, $parameters = [])
    {
        $reflector = new ReflectionClass($concrete);

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $instances = $this->resolveDependencies($dependencies, $parameters);

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * @param array $dependencies
     * @param $parameters
     * @return array
     * @throws \ReflectionException
     */
    private function resolveDependencies(array $dependencies, $parameters = [])
    {
        $results = [];

        foreach ($dependencies as $dependency) {

            if ($this->hasParameterOverride($dependency, $parameters)) {
                $results[] = $this->getParameterOverride($dependency, $parameters);

                continue;
            }

            $results[] = is_null($dependency->getClass())
                ? $this->resolvePrimitive($dependency)
                : $this->resolveClass($dependency);
        }

        return $results;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws \ReflectionException
     */
    private function resolvePrimitive(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        exit('Unresolvable dependency: ' . $parameter . 'in class' . $parameter->getDeclaringClass()->getName());
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws \ReflectionException
     */
    private function resolveClass(ReflectionParameter $parameter)
    {
        return $this->make($parameter->getClass()->name);
    }

    /**
     * @param $abstract
     * @return mixed
     */
    public function getAlias($abstract)
    {
        if (!isset($this->aliases[$abstract])) {
            return $abstract;
        }

        return $this->getAlias($this->aliases[$abstract]);
    }

    /**
     * @param $dependency
     * @param $parameters
     * @return bool
     */
    private function hasParameterOverride($dependency, $parameters = [])
    {
        return array_key_exists(
            $dependency->name, $parameters
        );
    }

    /**
     * @param $dependency
     * @param $parameters
     * @return mixed
     */
    private function getParameterOverride($dependency, $parameters)
    {
        return $parameters[$dependency->name];
    }





    /**
     * @param $controller
     * @return mixed
     */
    public static function controller($controller)
    {
        $controllerClass = "Controllers\\" . $controller;

        if (!class_exists($controllerClass)) {
            exit('Controller not found');
        }

        return new $controllerClass;
    }

    //TODO remove this
    public static function pageNotFound()
    {
        if (file_exists(__DIR__ . '/../views/404.php')) {
            require_once __DIR__ . '/../views/404.php';

            exit;
        } else {
            exit('Page not found');
        }
    }
}
