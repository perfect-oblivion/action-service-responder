<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Filters;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Contracts\Filter;

class Cast implements Filter
{
    /**
     * Cast the value to the given type.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    public function apply($value, $options = [])
    {
        $type = isset($options[0]) ? $options[0] : null;

        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return is_array($value) ? (object) $value : json_decode($value, false);
            case 'array':
                return json_decode($value, true);
            case 'collection':
                $array = is_array($value) ? $value : json_decode($value, true);

                return new Collection($array);
            default:
                throw new InvalidArgumentException("Wrong Sanitizer casting format: {$type}.");
        }
    }
}
