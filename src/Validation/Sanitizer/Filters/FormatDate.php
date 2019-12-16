<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Filters;

use Illuminate\Support\Carbon;
use InvalidArgumentException;
use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Contracts\Filter;

class FormatDate implements Filter
{
    /**
     * Format a date.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        if (! $value) {
            return $value;
        }

        if (count($options) != 2) {
            throw new InvalidArgumentException('The Sanitizer Format Date filter requires both the current date format as well as the target format.');
        }

        $currentFormat = trim($options[0]);
        $targetFormat = trim($options[1]);

        return Carbon::createFromFormat($currentFormat, $value)->format($targetFormat);
    }
}
