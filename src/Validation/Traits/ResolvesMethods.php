<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use ReflectionMethod;
use ReflectionParameter;

trait ResolvesMethods
{
    protected function resolveAndCall($instance, $method, $extras = [])
    {
        $parameters = $this->resolveMethodDependencies($instance, $method, $extras);

        return $instance->{$method}(...$parameters);
    }

    protected function resolveMethodDependencies($instance, $method, $extras = [])
    {
        if (! method_exists($instance, $method)) {
            return [];
        }

        $reflector = new ReflectionMethod($instance, $method);

        $handler = function ($parameter) use ($extras) {
            return $this->resolveDependency($parameter, $extras);
        };

        return array_map($handler, $reflector->getParameters());
    }

    protected function resolveDependency(ReflectionParameter $parameter, $extras = [])
    {
        list($key, $value) = $this->findAttributeFromParameter($parameter->name, $extras);
        $class = $parameter->getClass();

        if ($key && (! $class || $value instanceof $class->name)) {
            return $value;
        }

        if ($class) {
            return $this->resolveContainerDependency($class->name, $key, $value);
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
    }

    protected function resolveContainerDependency($class, $key, $value)
    {
        $instance = app($class);

        if ($key) {
            $this->updateAttributeWithResolvedInstance($key, $instance);
        }

        return $instance;
    }

    protected function resolveRouteBinding($instance, $value)
    {
        if (! $model = $instance->resolveRouteBinding($value)) {
            throw (new ModelNotFoundException)->setModel(get_class($instance));
        }

        return $model;
    }

    protected function findAttributeFromParameter($name, $extras = [])
    {
        $attributes = array_merge($this->all(), $extras);

        if (array_key_exists($name, $attributes)) {
            return [$name, $attributes[$name]];
        }
        if (array_key_exists($snakedName = Str::snake($name), $attributes)) {
            return [$snakedName, $attributes[$snakedName]];
        }
    }

    public function updateAttributeWithResolvedInstance($key, $instance)
    {
        return $this->all()[$key] = $instance;
    }
}
