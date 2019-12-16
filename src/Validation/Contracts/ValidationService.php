<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Contracts;

interface ValidationService
{
    /**
     * Validate the class instance.
     *
     * @param  array  $data
     */
    public function validate(array $data);
}
