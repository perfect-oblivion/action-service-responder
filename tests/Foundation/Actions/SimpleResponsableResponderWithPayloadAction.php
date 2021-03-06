<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Responders\Responder;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithPayload;

class SimpleResponsableResponderWithPayloadAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithPayload */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithPayload  $responder
     */
    public function __construct(SimpleResponderWithPayload $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     *  @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(): Responder
    {
        return $this->responder->withPayload('hello');
    }
}
