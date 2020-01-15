<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Contracts;

interface CachedService
{
    /**
     * Get the unique cache identifier for the Service.
     */
    public function cacheIdentifier(): string;

    /**
     * Get the cache time for the Service.
     *
     * @return \DateTimeInterface|\DateInterval|int|null
     */
    public function cacheTime();
}
