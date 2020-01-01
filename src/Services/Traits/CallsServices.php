<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Traits;

use Illuminate\Container\Container;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;

trait CallsServices
{
    /**
     * Call a service.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementals
     *
     * @return mixed
     */
    public function call(string $service, array $parameters, array $supplementals = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->call($service, $parameters, $supplementals);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementals
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     *
     * @return mixed
     */
    public function queue(string $service, array $parameters, array $supplementals = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue($service, $parameters, $supplementals);
    }
}
