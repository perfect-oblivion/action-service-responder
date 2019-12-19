<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Requests\CustomRequest;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithCustomRequest;

class SimpleResponderWithCustomRequestAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithCustomRequest */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithCustomRequest  $responder
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
        return $this->responder->withRequest($request)->respond();
    }
}
