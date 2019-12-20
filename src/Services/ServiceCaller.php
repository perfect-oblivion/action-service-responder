<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\ServiceHandlerMethodException;

class ServiceCaller extends AbstractServiceCaller
{
    /** @var \PerfectOblivion\ActionServiceResponder\Services\Service */
    protected $resolvedService;

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
        $this->prepareService($service);
        $this->validateData($params);

        return $this->shouldQueueService($this->resolvedService) ? $this->dispatchService($params) : $this->resolvedService->{$this::$handlerMethod}($params);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  mixed  $params
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     */
    public function queue($service, $params): void
    {
        $this->prepareService($service);
        $this->validateData($params);
        $this->dispatchService($params);
    }

    /**
     * Call the service's validator if it exists and hasn't been called yet.
     *
     * @param  array  $params
     */
    private function validateData(array $params = []): void
    {
        $validator = $this->resolvedService->getValidator();

        if ($validator && ! $this->resolvedService->isValidated()) {
            $this->resolvedService->setData($validator->validate($params));
            $this->resolvedService->setIsValidated(true);
        } else {
            $this->resolvedService->setData($params);
        }
    }

    /**
     * Dispatch a fully initialized Service to the queue.
     *
     * @param  array  $params
     */
    private function dispatchService(array $params): void
    {
        resolve(Dispatcher::class)->dispatch(new QueuedService($this->resolvedService, $params));
    }

    /**
     * Prepare the Service to be run.
     *
     * @param  mixed  $service
     */
    private function prepareService($service): void
    {
        $this->confirmServiceHasHandler($service);
        $this->temporarilyDisableAutorun();
        $this->resolvedService = $this->container->make($service);
        $this->resolvedService->parseRouteParameters();
    }

    /**
     * Temporarily disable the service autorun.
     */
    private function temporarilyDisableAutorun(): void
    {
        $this->container->resolving(Service::class, function($service, $app) {
            $service->autorunIfEnabled = false;
        });
    }

    /**
     * Confirm that a Service has a handler method.
     *
     * @param  string  $service
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Services\Exceptions\ServiceHandlerMethodException
     */
    private function confirmServiceHasHandler(string $service)
    {
        if (! $this->hasHandler($service)) {
            throw ServiceHandlerMethodException::notFound($service);
        }
    }

    /**
     * Should the Service be queued?
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     */
    private function shouldQueueService(Service $service): bool
    {
        return $service instanceof ShouldQueueService;
    }
}
