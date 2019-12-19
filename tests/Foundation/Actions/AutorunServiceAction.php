<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestAutorunService;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class AutorunServiceAction extends Action
{
    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(TestAutorunService $service)
    {
        return $service->result;
    }
}
