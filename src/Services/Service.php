<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Collection;
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
     * Automatically run the service.
     */
    public function autorun(): void
    {
        $this->parseRouteParameters();
        $validator = $this->getValidator();

        if ($validator) {
            $this->setValidatedData($validator->validate($validator->data));
            $validator->service = $this;
        } else {
            $this->setData(resolve('request')->all());
        }

        if ($this instanceof ShouldQueueService) {
            $this->autoQueue($this->data);
        } else {
            $this->result = $this->run($this->data);
        }
    }

    /**
     * Automatically queue the service.
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
    public function setData(array $data): self
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
     * Get the service route parameters.
     *
     * @return mixed
     */
    public function getRouteParameters($parameter = null)
    {
        if ($parameter) {
            if ($this->routeParameters && $this->routeParameters->has($parameter)) {
                return $this->routeParameters->get($parameter);
            }
        }

        return $this->routeParameters;
    }

    /**
     * Set the isValidated state for the service.
     *
     * @param  bool  $validated
     */
    public function setIsValidated(bool $validated): self
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
    public function setValidatedData(array $data): self
    {
        return $this->setData($data)->setIsValidated(true);
    }

    /**
     * Parse the route parameters for the Service.
     */
    public function parseRouteParameters(): self
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
