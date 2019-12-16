<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Filters;

use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Contracts\Filter;

class StripTags implements Filter
{
    /**
     * Strip tags from the given string.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? strip_tags($value) : $value;
    }
}
