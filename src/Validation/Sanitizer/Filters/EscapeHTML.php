<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Filters;

use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Contracts\Filter;

class EscapeHTML implements Filter
{
    /**
     * Remove HTML tags and encode special characters from the given string.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? filter_var($value, FILTER_SANITIZE_STRING) : $value;
    }
}
