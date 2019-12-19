<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use Illuminate\Http\Request;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestNoAutorunService;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class NoAutorunServiceAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestNoAutorunService */
    protected $service;

    /**
     * Construct a new NoAutorunServiceAction.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestNoAutorunService  $service
     */
    public function __construct(TestNoAutorunService $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        return $this->service->run($request->all());
    }
}
