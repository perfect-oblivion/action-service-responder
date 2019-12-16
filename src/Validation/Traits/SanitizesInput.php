<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Traits;

use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Laravel\SanitizesInput as BaseTrait;
use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Sanitizer;

trait SanitizesInput
{
    use BaseTrait;

    /**
     * Sanitize the data.
     */
    public function sanitizeData(): void
    {
        if ($this->filters()) {
            $sanitizer = new Sanitizer($this->all(), $this->filters());
            $this->replace($sanitizer->sanitize());
        }
    }
}
