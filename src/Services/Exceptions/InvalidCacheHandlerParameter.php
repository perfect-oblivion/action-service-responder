<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Exceptions;

use Exception;

class InvalidCacheHandlerParameter extends Exception
{
    /** @var string */
    const INVALID_SERVICE_MESSAGE = "CacheHandler::%s was called with an invalid argument. You must pass a string or a Service class.";

    /**
     * Create a new InvalidCacheHandlerParameter for missing cache identifier.
     */
    public static function invalidService(string $function): self
    {
        return new self(sprintf(static::INVALID_SERVICE_MESSAGE, $function));
    }
}
