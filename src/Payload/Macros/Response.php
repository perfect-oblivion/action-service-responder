<?php

namespace PerfectOblivion\ActionServiceResponder\Payload\Macros;

use PerfectOblivion\ActionServiceResponder\Payload\Contracts\PayloadContract;
use Illuminate\Support\Facades\Response as ResponseFactory;

class Response
{
    /**
     * Response macro to send a json response based on a domain payload.
     *
     * @return mixed
     */
    public function jsonWithPayload()
    {
        return function (PayloadContract $payload) {
            return ResponseFactory::json($payload, $payload->getStatus());
        };
    }

    /**
     * Response macro to send a response based on a payload.
     *
     * @return mixed
     */
    public function viewWithPayload()
    {
        return function (string $view, PayloadContract $payload, string $key = 'payload') {
            return ResponseFactory::view($view, [$key => $payload->getRawOutput()], $payload->getStatus());
        };
    }
}
