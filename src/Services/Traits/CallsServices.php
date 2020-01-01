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
     * @param  array  $supplementalParameters
     *
     * @return mixed
     */
    public function call(string $service, array $parameters, array $supplementalParameters = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->call($service, $parameters, $supplementalParameters);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementalParameters
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     *
     * @return mixed
     */
    public function queue(string $service, array $parameters, array $supplementalParameters = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue($service, $parameters, $supplementalParameters);
    }
}
