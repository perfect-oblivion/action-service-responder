<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Support\Collection;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\DuplicateSupplementalItemException;

class Supplementals extends Collection
{
    /**
     * Construct a new Supplementals object.
     *
     * @param  array  $items
     */
    public function __construct(? array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * Create a new Supplementals object.
     *
     * @param  array  $items
     */
    public static function create(? array $items = []): self
    {
        return new self($items);
    }

    /**
     * Add the given item to the current object.
     *
     * @param  mixed  $data
     */
    public function addItems($items): self
    {
        if ($items) {
            collect($items)->each(function ($item, $key) {
                if ($this->has($key)) {
                    throw DuplicateSupplementalItemException::create($key);
                }
                $this[$key] = $item;
            });
        }

        return $this;
    }
}
