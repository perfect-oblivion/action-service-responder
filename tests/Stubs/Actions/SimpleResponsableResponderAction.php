<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Responders\Responder;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponder;

class SimpleResponsableResponderAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponder */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponder  $responder
     */
    public function __construct(SimpleResponder $responder)
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
        return $this->responder;
    }
}
