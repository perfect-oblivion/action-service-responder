<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService;

abstract class Service
{
    /** @var array */
    protected $data = [];

    /** @var \Illuminate\Support\Collection|null */
    protected $routeParameters;

    /** @var mixed */
    public $result;

    /** @var bool */
    protected $validated = false;

    /** @var bool */
    public $autorunIfEnabled = true;

    /**
     * Automatically run the service
     */
    public function autorun(): void
    {
        $this->parseRouteParameters();
        $validator = $this->getValidator();
        $validator ? $this->setValidatedData($validator->validate($validator->data)) : $this->setData(resolve('request')->all());

        if ($this instanceof ShouldQueueService) {
            $this->autoQueue($this->data);
        } else {
            $this->result = $this->run($this->data);
        }
    }

    /**
     * Automatically queue the service
     *
     * @param  array  $parameters
     */
    public function autoQueue(array $parameters): void
    {
        resolve(Dispatcher::class)->dispatch(new QueuedService($this, $parameters));
    }

    /**
     * Get the service validator.
     */
    public function getValidator(): ? ValidationService
    {
        return property_exists($this, 'validator') ? $this->validator : null;
    }

    /**
     * Set the data for the service.
     *
     * @param  array  $data
     */
    public function setData(array $data): Service
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the service data.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set the isValidated state for the service.
     *
     * @param  bool  $validated
     */
    public function setIsValidated(bool $validated): Service
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Has the service data been validated?
     */
    public function isValidated(): bool
    {
        return $this->validated;
    }

    /**
     * Set the validated data for the service.
     *
     * @param  array  $data
     */
    public function setValidatedData(array $data): Service
    {
        return $this->setData($data)->setIsValidated(true);
    }

    /**
     * Parse the route parameters for the Service.
     */
    public function parseRouteParameters(): Service
    {
        $this->routeParameters = collect(optional(resolve('request')->route())->parameters());

        return $this;
    }

    /**
     * Run the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    abstract public function run(array $parameters);
}
