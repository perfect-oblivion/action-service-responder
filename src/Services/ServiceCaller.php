<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher;
use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\ServiceHandlerMethodException;

class ServiceCaller extends AbstractServiceCaller
{
    /**
     * Call a service through its appropriate handler.
     *
     * @param  string  $service
     * @param  mixed  $params
     *
     * @return mixed
     */
    public function call($service, $params)
    {
        $service::$autoRun = false;

        if (! $this->hasHandler($service)) {
            throw ServiceHandlerMethodException::notFound($service);
        }

        $resolved = $this->container->make($service);
        $this->callValidator($resolved, $params);

        if ($resolved instanceof ShouldQueueService) {
            return $this->queue($service, $params);
        }

        return $resolved->{$this::$handlerMethod}($params);
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
    public function queue($service, $params)
    {
        $service::$autoRun = false;

        if (! $this->hasHandler($service)) {
            throw ServiceHandlerMethodException::notFound($service);
        }

        $resolved = Container::getInstance()->make($service);
        $this->callValidator($resolved, $params);

        return resolve(Dispatcher::class)->dispatch(new QueuedService($resolved, $params));
    }

    /**
     * Call the service's validator if it exists and hasn't been called yet.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     * @param  array  $params
     */
    protected function callValidator(Service $service, array $params = []): void
    {
        $validator = $service->getValidator();

        if ($validator && ! $service->isValidated()) {
            $service->setData($validator->validate($params));
            $service->setIsValidated(true);
        }
    }
}
