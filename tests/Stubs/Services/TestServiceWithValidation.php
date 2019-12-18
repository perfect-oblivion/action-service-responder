<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services;

use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\Traits\SelfCallingService;

class TestServiceWithValidation extends Service
{
    use SelfCallingService;

    /** @var bool */
    public static $autoRun = false;

    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services\TestServiceValidator */
    protected $validator;

    /**
     * Construct a new TestServiceWithValidator.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services\TestServiceValidator  $validator
     */
    public function __construct(TestServiceValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function run(array $parameters)
    {
        return ['name' => $parameters['name'], 'validated' => $this->isValidated()];
    }
}
