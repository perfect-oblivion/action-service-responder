<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use PerfectOblivion\ActionServiceResponder\Services\Service;

class QueuedService implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    /** @var string */
    protected $serviceClass;

    /** @var \PerfectOblivion\ActionServiceResponder\Services\Service */
    protected $service;

    /** @var array */
    protected $parameters;

    /**
     * Construct a new QueuedService.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\Service  $service
     * @param  array  $parameters
     */
    public function __construct(Service $service, array $parameters)
    {
        $this->serviceClass = get_class($service);
        $this->service = $service;
        $this->parameters = $parameters;
        $this->resolveQueueableProperties($service);
    }

    /**
     * Get the display name for the class.
     *
     * @return string
     */
    public function displayName()
    {
        return $this->serviceClass;
    }

    /**
     * Handle the QueuedService.
     */
    public function handle()
    {
        $this->service->run($this->parameters);
    }

    /**
     * The tags for identifying the queued service.
     *
     * @return array
     */
    public function tags()
    {
        return ['queued_service'];
    }

    /**
     * Resolve the queable properties.
     */
    protected function resolveQueueableProperties()
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
            $this->{$queueableProperty} = $this->service->{$queueableProperty} ?? $this->{$queueableProperty};
        }
    }
}
