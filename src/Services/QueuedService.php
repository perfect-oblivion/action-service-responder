<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\Traits\DisablesAutorun;

class QueuedService implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable, DisablesAutorun;

    /** @var array */
    protected $data;

    /** @var array */
    protected $parameters;

    /** @var array */
    public $queueableProperties = [
        'connection',
        'queue',
        'chainConnection',
        'chainQueue',
        'delay',
        'chained',
        'tries',
        'timeout',
    ];

    /** @var string */
    protected $serviceClass;

    /** @var \Illuminate\Support\Collection */
    protected $supplementals;

    /** @var bool */
    protected $validated;

    /**
     * Construct a new QueuedService.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     * @param  array  $parameters
     */
    public function __construct(Service $service, array $parameters)
    {
        $this->serviceClass = get_class($service);
        $this->parameters = $parameters;
        $this->copyServiceProperties($service);
        $this->resolveQueueableProperties($service);
    }

    /**
     * Handle the QueuedService.
     */
    public function handle(): void
    {
        $this->disableAutorun();
        $service = resolve($this->serviceClass);
        $this->setCopiedServiceProperties($service);

        $service->run($this->parameters);
    }

    /**
     * Get the display name for the class.
     */
    public function displayName(): string
    {
        return $this->serviceClass;
    }

    /**
     * The tags for identifying the queued service.
     */
    public function tags(): array
    {
        return ['queued_service'];
    }

    /**
     * Set the properties for the Service
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     */
    private function copyServiceProperties(Service $service): void
    {
        $this->supplementals = $service->getSupplementals();
        $this->data = $service->data;
        $this->validated = $service->isValidated();
    }

    /**
     * Set the copied properties on the Service.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     */
    private function setCopiedServiceProperties(Service $service): Service
    {
        $service->data = $this->data;
        $service->supplementals = $this->supplementals;
        $service->validated = $this->validated;

        return $service;
    }

    /**
     * Resolve the queable properties.
     *
     * @param  mixed  $service
     */
    private function resolveQueueableProperties($service): void
    {
        foreach ($this->queueableProperties as $queueableProperty) {
            if (property_exists($service, $queueableProperty)) {
                $this->{$queueableProperty} = $service->{$queueableProperty};
            }
        }
    }
}
