<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Traits;

use Illuminate\Container\Container;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;

trait SelfCallingService
{
    /**
     * Run the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public static function call(array $parameters)
    {
        return Container::getInstance()->make(ServiceCaller::class)->call(static::class, $parameters);
    }

    /**
     * Push the service call to the queue.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public static function queue(array $parameters)
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue(static::class, $parameters);
    }
}
