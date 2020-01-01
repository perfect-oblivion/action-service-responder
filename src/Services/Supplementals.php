<?php

namespace PerfectOblivion\ActionServiceResponder\Services;

use Illuminate\Support\Collection;

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
     * Merge the current object with the given data.
     *
     * @param  array  $data
     */
    public function merge($items): self
    {
        if ($items) {
            return $this->mergeRecursive($items);
        }

        return $this;
    }
}
