<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions;

use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithPayload;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services\TestServiceObjectPayload;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class ServiceObjectResponderPayloadAction extends Action
{
    /** @var \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithPayload */
    private $responder;

    /**
     * Construct a new SimpleResponderAction
     *
     * @param  \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Responders\SimpleResponderWithPayload  $responder
     */
    public function __construct(SimpleResponderWithPayload $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     *  @param  \PerfectOblivion\ActionServiceResponder\Tests\Stubs\Services\TestServiceObjectPayload  $service
     */
    public function __invoke(TestServiceObjectPayload $service)
    {
        return $this->responder->withPayloadFrom($service)->respond();
    }
}
