<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Foundation\Responders;

use PerfectOblivion\ActionServiceResponder\Responders\Responder;

class SimpleResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return 'hello';
    }
}
