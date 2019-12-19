<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Actions\Action;
use PerfectOblivion\ActionServiceResponder\Responders\Responder;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponder;

class SimpleResponsableResponderAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponder */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponder  $responder
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
