<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use Illuminate\Http\Request;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestService;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class SimpleServiceAction extends Action
{
    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        return TestService::call($request->all());
    }
}
