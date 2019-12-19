<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders;

use PerfectOblivion\ActionServiceResponder\Responders\Responder;

class SimpleResponderWithCustomRequest extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return get_class($this->request);
    }
}
