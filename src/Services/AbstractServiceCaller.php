<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Container\Container;

abstract class AbstractServiceCaller
{
    /** @var \Illuminate\Contracts\Container\Container */
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
     * @param  array  $supplementalParameters
     *
     * @return mixed
     */
    abstract public function call(string $service, array $parameters = [], array $supplementalParameters = []);

    /**
     * Queue a service.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementalParameters
     */
    abstract public function queue(string $service, array $parameters = [], array $supplementalParameters = []): void;

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
