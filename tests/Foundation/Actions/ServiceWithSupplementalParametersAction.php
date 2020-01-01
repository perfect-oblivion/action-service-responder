<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use Illuminate\Http\Request;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Models\User;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestServiceWithSupplementalParameters;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class ServiceWithSupplementalParametersAction extends Action
{
    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request, User $user)
    {
        return TestServiceWithSupplementalParameters::call($request->all());
    }
}
