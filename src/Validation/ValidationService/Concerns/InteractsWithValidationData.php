<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\ValidationService\Concerns;

use Illuminate\Support\Arr;
use stdClass;

trait InteractsWithValidationData
{
    /**
     * Get all data under validation.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $rules = $this->resolveAndCall($this, 'rules', $this->service->getSupplementals());

        return $this->only(collect($rules)->keys()->map(function ($rule) {
            return explode('.', $rule)[0];
        })->unique()->toArray());
    }

    /**
     * Get a subset containing the provided keys with values from the given data.
     *
     * @param  array|mixed  $keys
     *
     * @return array
     */
    public function only($keys)
    {
        $results = [];

        $input = $this->all();

        $placeholder = new stdClass;

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $value = data_get($input, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }

    /**
     * Replaces the current data with a new set.
     *
     * @param  array  $data
     */
    public function replace(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Replaces the current data with a new set.
     *
     * @param  array  $data
     */
    public function setData(array $data): void
    {
        $this->replace($data);
    }
}
