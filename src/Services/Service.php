<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Support\Facades\Cache;
use PerfectOblivion\ActionServiceResponder\Services\Contracts\CachedService;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCachedService;
use PerfectOblivion\ActionServiceResponder\Services\Supplementals;
use PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService;

abstract class Service
{
    /** @var mixed */
    public $result;

    /** @var bool */
    public $autorunIfEnabled = true;

    /** @var array */
    public $data = [];

    /** @var \PerfectOblivion\ActionServiceResponder\Services\Supplementals|null */
    public $supplementals;

    /** @var bool */
    public $validated = false;

    /** @var \PerfectOblivion\ActionServiceResponder\Validation\Contracts\ValidationService|null */
    protected $validator;

    /**
     * Automatically run the service.
     */
    public function autorun(): void
    {
        $this->buildSupplementals();
        $validator = $this->getValidator();

        if ($validator) {
            $validator->service = $this;
            $this->setValidatedData($validator->validate($validator->data));
        } else {
            $this->setData(app()->make('request')->all());
        }

        if ($this instanceof CachedService) {
            $this->result = $this->runCached($this->data);
        } else {
            $this->result = $this->run($this->data);
        }
    }

    /**
     * Get the service validator.
     */
    public function getValidator(): ? ValidationService
    {
        return property_exists($this, 'validator') ? $this->validator : null;
    }

    /**
     * Set the data for the service.
     *
     * @param  array  $data
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the service data.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the cache key for the service.
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCachedService
     */
    public function getCacheKey(): string
    {
        throw_unless(method_exists($this, 'cacheIdentifier'), InvalidCachedService::missingCacheIdentifier(static::class));

        return app()->call([$this, 'cacheIdentifier']);
    }

    /**
     * Get the cache ttl.
     *
     * @return \DateTimeInterface|\DateInterval|int|null
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCachedService
     */
    public function getCacheTime()
    {
        throw_unless(method_exists($this, 'cacheTime'), InvalidCachedService::missingCacheTime(static::class));

        return app()->call([$this, 'cacheTime']);
    }

    /**
     * Forget the cached Service result by key.
     *
     * @throws \PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidCachedService
     */
    public function forgetCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Build the supplementals for the service.
     *
     * @param  array  $supplementals
     */
    public function buildSupplementals(array $supplementals = []): self
    {
        $routeParameters = optional(app()->make('request')->route())->parametersWithoutNulls();

        $combined = Supplementals::create($supplementals)->addItems($routeParameters);

        if ($this->supplementals instanceof Supplementals) {
            $this->supplementals = $this->supplementals->addItems($combined);
        } else {
            $this->supplementals = $combined;
        }

        return $this;
    }

    /**
     * Set the supplementals for the service.
     *
     * @param  mixed  $supplementals
     */
    public function setSupplementals($supplementals): self
    {
        if ($supplementals instanceof Supplementals) {
            $this->supplementals = $supplementals;
        } else {
            $this->supplementals = Supplementals::create($supplementals);
        }

        return $this;
    }

    /**
     * Get the service supplemental parameters.
     *
     * @return mixed
     */
    public function getSupplementals($parameter = null)
    {
        if ($parameter) {
            if ($this->supplementals && $this->supplementals->has($parameter)) {
                return $this->supplementals->get($parameter);
            }
        }

        return $this->supplementals->all();
    }

    /**
     * Set the isValidated state for the service.
     *
     * @param  bool  $validated
     */
    public function setIsValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Has the service data been validated?
     */
    public function isValidated(): bool
    {
        return $this->validated;
    }

    /**
     * Set the validated data for the service.
     *
     * @param  array  $data
     */
    public function setValidatedData(array $data): self
    {
        return $this->setData($data)->setIsValidated(true);
    }

    /**
     * Run cached service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function runCached(array $parameters)
    {
        return Cache::remember($this->getCacheKey(), $this->getCacheTime(), function () use ($parameters) {
            return $this->run($parameters);
        });
    }

    /**
     * Run the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    abstract public function run(array $parameters = []);

    public function __get(string $key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        if (array_key_exists($key, $this->supplementals->all())) {
            return $this->getSupplementals($key);
        }
    }
}
