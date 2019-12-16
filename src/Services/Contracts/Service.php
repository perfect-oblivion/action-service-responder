<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Contracts;

abstract class Service
{
    /** @var array */
    protected $validated;

    /** @var mixed */
    public $result;

    /** @var bool */
    public static $autoRun = true;

    /**
     * Automatically run the service
     */
    public function autoRun(): void
    {
        $this->validated = $this->validator->validate();
        $this->result = $this->run($this->validated);
    }

    /**
     * Automatically queue the service
     */
    public function autoQueue(): void
    {
        $this->validated = $this->validator->validate();

        resolve(\PerfectOblivion\ActionServiceResponder\Services\ServiceCaller::class)->call(get_class($this), $this->validated);
    }

    /**
     * Run the service.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    abstract public function run(array $data);
}
