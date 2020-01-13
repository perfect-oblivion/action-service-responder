<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\ServiceHandlerMethodException;
use PerfectOblivion\ActionServiceResponder\Services\Traits\DisablesAutorun;

class ServiceCaller extends AbstractServiceCaller
{
    use DisablesAutorun;

    /** @var \PerfectOblivion\ActionServiceResponder\Services\Service */
    protected $resolvedService;

    /**
     * Call a service through its appropriate handler.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementalParameters
     *
     * @return mixed
     */
    public function call(string $service, array $parameters = [], array $supplementalParameters = [])
    {
        $this->prepareService($service, $supplementalParameters);
        $this->validateData($parameters);

        return $this->shouldQueueService() ? $this->dispatchService($parameters) : $this->resolvedService->run($parameters);
    }

    /**
     * Push the service call to the queue.
     *
     * @param  string  $service
     * @param  array  $parameters
     * @param  array  $supplementalParameters
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Exceptions\ServiceHandlerMethodException
     */
    public function queue(string $service, array $parameters = [], array $supplementalParameters = []): void
    {
        $this->prepareService($service, $supplementalParameters);
        $this->validateData($parameters);
        $this->dispatchService($parameters);
    }

    /**
     * Prepare the Service to be run.
     *
     * @param  string  $service
     * @param  array  $supplementalParameters
     */
    private function prepareService(string $service, array $supplementalParameters): void
    {
        $this->confirmServiceHasHandler($service);
        $this->disableAutorun();
        $this->resolvedService = $this->container->make($service);
        $this->resolvedService->buildSupplementals($supplementalParameters);
    }

    /**
     * Call the service's validator if it exists and hasn't been called yet.
     *
     * @param  array  $parameters
     */
    private function validateData(array $parameters = []): void
    {
        $validator = $this->resolvedService->getValidator();

        if ($validator) {
            $validator->service = $this->resolvedService;
            if (! $this->resolvedService->isValidated()) {
                $this->resolvedService->setData($validator->validate($parameters));
                $this->resolvedService->setIsValidated(true);
            }
        } else {
            $this->resolvedService->setData($parameters);
        }
    }

    /**
     * Dispatch a fully initialized Service to the queue.
     *
     * @param  array  $parameters
     */
    private function dispatchService(array $parameters): void
    {
        resolve(Dispatcher::class)->dispatch(new QueuedService($this->resolvedService, $parameters));
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
        throw_unless($this->hasHandler($service), ServiceHandlerMethodException::notFound($service));
    }

    /**
     * Should the Service be queued?
     */
    private function shouldQueueService(): bool
    {
        return $this->resolvedService instanceof ShouldQueueService;
    }
}
