<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Filters;

use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Contracts\Filter;

class Digit implements Filter
{
    /**
     * Get only digit characters from the string.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return preg_replace('/[^0-9]/si', '', $value);
    }
}
