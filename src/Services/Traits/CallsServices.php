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
     * @param  mixed  $params
     *
     * @return mixed
     */
    public function call(string $service, $params)
    {
        return Container::getInstance()->make(ServiceCaller::class)->call($service, $params);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  mixed  $params
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     *
     * @return mixed
     */
    public function queue(string $service, $params)
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue($service, $params);
    }
}
