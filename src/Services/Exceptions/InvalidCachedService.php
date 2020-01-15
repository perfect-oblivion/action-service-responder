<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Exceptions;

use Exception;

class InvalidCachedService extends Exception
{
    /**
     * Create a new InvalidCachedService for missing cache identifier.
     *
     * @param  string  $class
     */
    public static function missingCacheIdentifier(string $class): self
    {
        return new self(sprintf("Class, %s, is missing the 'cacheIdentifier' method.", $class));
    }

    /**
     * Create a new InvalidCachedService for missing cache time.
     *
     * @param  string  $class
     */
    public static function missingCacheTime(string $class): self
    {
        return new self(sprintf("Class, %s, is missing the 'cacheTime' method.", $class));
    }
}
