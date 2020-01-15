<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Support\Facades\Cache;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCacheHandlerParameter;
use PerfectOblivion\ActionServiceResponder\Services\Traits\DisablesAutorun;

class CacheHandler
{
    use DisablesAutorun;

    /**
     * Forge the cache for the given key.
     *
     * @param  mixed  $service
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCacheHandlerParameter
     */
    public static function forget($service): void
    {
        throw_unless(is_string($service) || $service instanceof Service, InvalidCacheHandlerParameter::invalidService(__FUNCTION__));

        if (is_string($service)) {
            static::disableAutorun();

            $service = app()->make($service);
        }

        Cache::forget($service->getCacheKey());
    }
}
