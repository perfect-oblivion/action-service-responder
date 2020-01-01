<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Container\Container;

abstract class AbstractServiceCaller
{
    /**
     * The container implementation.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new service caller instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Call a service.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementals
     *
     * @return mixed
     */
    abstract public function call(string $service, array $parameters, array $supplementals = []);

    /**
     * Queue a service.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementals
     */
    abstract public function queue(string $service, array $parameters, array $supplementals = []): void;

    /**
     * Determine if the service handler method exists.
     *
     * @param  mixed  $service
     */
    public function hasHandler($service): bool
    {
        return method_exists($service, 'run');
    }
}
