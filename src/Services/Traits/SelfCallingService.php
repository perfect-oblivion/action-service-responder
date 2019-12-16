<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Traits;

use Illuminate\Container\Container;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;

trait SelfCallingService
{
    /**
     * Run the service.
     *
     * @return mixed
     */
    public static function call()
    {
        return Container::getInstance()->make(ServiceCaller::class)->call(static::class, ...func_get_args());
    }

    /**
     * Push the service call to the queue.
     *
     * @return mixed
     */
    public static function queue()
    {
        return Container::getInstance()->make(ServiceCaller::class)->queue(static::class, ...func_get_args());
    }
}
