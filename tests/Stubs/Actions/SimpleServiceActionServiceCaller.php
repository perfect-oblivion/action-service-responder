<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions;

use Illuminate\Http\Request;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services\TestServiceCallerService;
use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;

class SimpleServiceActionServiceCaller extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Services\ServiceCaller */
    protected $caller;

    /**
     * Construct a new SimpleServiceActionServiceCaller.
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Services\ServiceCaller  $caller
     */
    public function __construct(ServiceCaller $caller)
    {
        $this->caller = $caller;
    }

    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): array
    {
        return $this->caller->call(TestServiceCallerService::class, $request->all());
    }
}
