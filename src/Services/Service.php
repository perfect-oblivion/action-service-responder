<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\ShouldQueueService;
use PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService;

abstract class Service
{
    /** @var array */
    protected $data = [];

    /** @var mixed */
    public $result;

    /** @var bool */
    protected $validated = false;

    /** @var bool */
    public static $autoRun = true;

    /**
     * Automatically run the service
     */
    public function autoRun(): void
    {
        if ($this instanceof ShouldQueueService) {
            $this->autoQueue();
        } else {
            $this->result = $this->run($this->data);
        }
    }

    /**
     * Automatically queue the service
     */
    public function autoQueue(): void
    {
        resolve(ServiceCaller::class)->call(get_class($this), $this->data);
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
     * Run the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    abstract public function run(array $parameters);
}
