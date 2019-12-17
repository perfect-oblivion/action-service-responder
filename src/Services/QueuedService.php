<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class QueuedService implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    /** @var string */
    protected $serviceClass;

    /** @var array */
    protected $parameters;

    /**
     * Construct a new QueuedService.
     *
     * @param  mixed  $service
     * @param  array  $parameters
     */
    public function __construct($service, array $parameters)
    {
        $this->serviceClass = get_class($service);

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
        $service = app($this->serviceClass);
        $method = Config::get('asr.service_method', 'run');

        $service->{$method}($this->parameters);
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
     *
     * @param  mixed  $service
     */
    protected function resolveQueueableProperties($service)
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
}
