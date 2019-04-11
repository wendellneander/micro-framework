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
    /**
     * @var $instance self
     */
    private static $instance;

    /**
     * @var $aliases array
     */
    protected $aliases;

    /**
     * @return Container
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @param $abstract
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function make($abstract, $parameters = [])
    {
        $parameters = is_array($parameters) ? $parameters : [];

        return $this->build($abstract, $parameters);
    }

    /**
     * @param $concrete
     * @param $parameters
     * @return object
     * @throws \ReflectionException
     */
    protected function build($concrete, $parameters = [])
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
    protected function resolveDependencies(array $dependencies, $parameters = [])
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
    protected function resolvePrimitive(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        exit('Unresolvable dependency: ' . $parameter . ' in class' . $parameter->getDeclaringClass()->getName());
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws \ReflectionException
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        return $this->make($parameter->getClass()->name);
    }

    /**
     * @param $dependency
     * @param $parameters
     * @return bool
     */
    protected function hasParameterOverride($dependency, $parameters = [])
    {
        return array_key_exists($dependency->name, $parameters);
    }

    /**
     * @param $dependency
     * @param $parameters
     * @return mixed
     */
    protected function getParameterOverride($dependency, $parameters)
    {
        return $parameters[$dependency->name];
    }
}
