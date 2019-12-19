<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders;

use PerfectOblivion\ActionServiceResponder\Responders\Responder;

class SimpleResponderWithPayload extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return $this->payload;
    }
}
