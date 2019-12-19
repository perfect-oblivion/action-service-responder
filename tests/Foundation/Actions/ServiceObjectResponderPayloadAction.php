<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions;

use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders\SimpleResponderWithPayload;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestServiceObjectPayload;
use PerfectOblivion\ActionServiceResponder\Actions\Action;

class ServiceObjectResponderPayloadAction extends Action
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
     *  @param  \PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestServiceObjectPayload  $service
     */
    public function __invoke(TestServiceObjectPayload $service)
    {
        return $this->responder->withPayloadFrom($service)->respond();
    }
}
