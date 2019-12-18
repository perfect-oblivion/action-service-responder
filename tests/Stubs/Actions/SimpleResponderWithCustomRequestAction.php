<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Requests\CustomRequest;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithCustomRequest;

class SimpleResponderWithCustomRequestAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithCustomRequest */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithCustomRequest  $responder
     */
    public function __construct(SimpleResponderWithCustomRequest $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(CustomRequest $request): string
    {
        dump('instance of: ', get_class($request));
        return $this->responder->withRequest($request)->respond();
    }
}
