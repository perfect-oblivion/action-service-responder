<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Collection;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService;

abstract class Service
{
    /** @var mixed */
    public $result;

    /** @var bool */
    public $autorunIfEnabled = true;

    /** @var array */
    protected $data = [];

    /** @var \Illuminate\Support\Collection|null */
    protected $supplementals;

    /** @var bool */
    protected $validated = false;

    /** @var \PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService|null */
    protected $validator;

    /**
     * Automatically run the service.
     */
    public function autorun(): void
    {
        $this->buildSupplementals();
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
     * Build the supplementals for the service.
     *
     * @param  array  $supplementals
     */
    public function buildSupplementals(array $supplementals = []): self
    {
        $passed = new Collection($supplementals);
        $route = resolve('request')->route();
        $routeParameters = $route ? new Collection($route->parameters()) : null;
        $exists = $this->supplementals && $this->supplementals instanceof Collection;
        $combined = $passed->merge($routeParameters);

        if ($exists) {
            $this->supplementals = $this->supplementals->merge($combined);
        } else {
            $this->supplementals = $combined;
        }

        return $this;
    }

    /**
     * Set the supplementals for the service.
     *
     * @param  \Illuminate\Support\Collection  $supplementals
     */
    public function setSupplementals(Collection $supplementals): self
    {
        $this->supplementals = $supplementals;

        return $this;
    }

    /**
     * Get the service supplemental parameters.
     *
     * @return mixed
     */
    public function getSupplementals($parameter = null)
    {
        if ($parameter) {
            if ($this->supplementals && $this->supplementals->has($parameter)) {
                return $this->supplementals->get($parameter);
            }
        }

        return $this->supplementals;
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
     * Run the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    abstract public function run(array $parameters);
}
