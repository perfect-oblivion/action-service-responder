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
     * @param  array  $params
     * @param  array  $supplementals
     *
     * @return mixed
     */
    public function call(string $service, array $params, array $supplementals = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->call($service, $params, $supplementals);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  array  $params
     * @param  array  $supplementals
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     *
     * @return mixed
     */
    public function queue(string $service, array $params, array $supplementals = [])
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue($service, $params, $supplementals);
    }
}
