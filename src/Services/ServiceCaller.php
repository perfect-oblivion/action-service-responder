<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Collection;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\ServiceHandlerMethodException;
use PerfectOblivion\ActionServiceResponder\Services\Service;

class ServiceCaller extends AbstractServiceCaller
{
    /** @var \PerfectOblivion\ActionServiceResponder\Services\Service */
    protected $resolvedService;

    /**
     * Call a service through its appropriate handler.
     *
     * @param  string  $service
     * @param  array  $params
     * @param  array  $supplementals
     *
     * @return mixed
     */
    public function call(string $service, array $params, array $supplementals = [])
    {
        $this->prepareService($service, $supplementals);
        $this->validateData($params);

        return $this->shouldQueueService($this->resolvedService)
            ? $this->dispatchService(
                $params,
                $this->resolvedService->getData(),
                $this->resolvedService->isValidated(),
                $this->resolvedService->getSupplementals(),
                get_object_vars($this->resolvedService),
            )
            : $this->resolvedService->run($params);
    }

    /**
     * Push the service call to the queue..
     *
     * @param  string  $service
     * @param  array  $params
     * @param  array  $supplementals
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     */
    public function queue(string $service, array $params, array $supplementals = []): void
    {
        $this->prepareService($service, $supplementals);
        $this->validateData($params);
        $this->dispatchService(
            $params,
            $this->resolvedService->getData(),
            $this->resolvedService->isValidated(),
            $this->resolvedService->getSupplementals(),
            get_object_vars($this->resolvedService),
        );
    }

    /**
     * Prepare the Service to be run.
     *
     * @param  string  $service
     * @param  array  $supplementals
     */
    private function prepareService(string $service, array $supplementals): void
    {
        $this->confirmServiceHasHandler($service);
        $this->temporarilyDisableAutorun();
        $this->resolvedService = $this->container->make($service);
        $this->resolvedService->buildSupplementals($supplementals);
    }

    /**
     * Call the service's validator if it exists and hasn't been called yet.
     *
     * @param  array  $params
     */
    private function validateData(array $params = []): void
    {
        $validator = $this->resolvedService->getValidator();

        if ($validator) {
            $validator->service = $this->resolvedService;
            if (! $this->resolvedService->isValidated()) {
                $this->resolvedService->setData($validator->validate($params));
                $this->resolvedService->setIsValidated(true);
            }
        } else {
            $this->resolvedService->setData($params);
        }
    }

    /**
     * Dispatch a fully initialized Service to the queue.
     *
     * @param  array  $params
     * @param  array  $data
     * @param  bool  $validated
     * @param  \Illuminate\Support\Collection  $supplementals
     * @param  array  $props
     */
    private function dispatchService(array $params, array $data, bool $validated, Collection $supplementals, array $props): void
    {
        resolve(Dispatcher::class)->dispatch(new QueuedService($this->resolvedService, $params, $data, $validated, $supplementals, $props));
    }

    /**
     * Temporarily disable the service autorun.
     */
    private function temporarilyDisableAutorun(): void
    {
        $this->container->resolving(Service::class, function ($service, $app) {
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
