<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services;

use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\Traits\SelfCallingService;

class TestServiceWithSupplementalParameters extends Service
{
    use SelfCallingService;

    /**
     * Handle the call to the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function run(array $parameters)
    {
        return ['name' => $this->data['name'], 'user' => $this->getSupplementals('user')->name];
    }
}
