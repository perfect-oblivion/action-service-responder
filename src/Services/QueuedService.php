<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use PerfectOblivion\ActionServiceResponder\Services\Service;

class QueuedService implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    /** @var string */
    protected $serviceClass;

    /** @var array */
    protected $parameters;

    /** @var array */
    protected $data;

    /** @var bool */
    protected $validated;

    /** @var \Illuminate\Support\Collection */
    protected $supplementals;

    /** @var array */
    protected $props;

    /**
     * Construct a new QueuedService.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     * @param  array  $parameters
     * @param  array  $data
     * @param  bool  $validated
     * @param  \Illuminate\Support\Collection  $supplementals
     * @param  array  $props
     */
    public function __construct(Service $service, array $parameters, array $data, bool $validated, Collection $supplementals, array $props)
    {
        $this->serviceClass = get_class($service);
        $this->parameters = $parameters;
        $this->data = $data;
        $this->validated = $validated;
        $this->supplementals = $supplementals;
        $this->props = $props;
        $this->resolveQueueableProperties($service);
    }

    /**
     * Handle the QueuedService.
     */
    public function handle(): void
    {
        $service = resolve($this->serviceClass);
        $this->setRequiredServiceProperties($service);
        $this->setPublicServiceProperties($service);
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
     * Resolve the queable properties.
     *
     * @param  mixed  $service
     */
    protected function resolveQueueableProperties($service): void
    {
        $queueableProperties = [
            'connection',
            'queue',
            'chainConnection',
            'chainQueue',
            'delay',
            'chained',
        ];

        foreach ($queueableProperties as $queueableProperty) {
            $this->{$queueableProperty} = $service->{$queueableProperty} ?? $this->{$queueableProperty};
        }
    }

    /**
     * Set the required Service properties.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     */
    private function setRequiredServiceProperties(Service $service): void
    {
        $service->setData($this->data);
        $service->setIsValidated($this->validated);
        $service->setSupplementals($this->supplementals);
    }

    /**
     * Set the public properties for the Service
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     */
    private function setPublicServiceProperties(Service $service): void
    {
        foreach($this->props as $key => $value) {
            $service->{$key} = $value;
        }
    }
}
