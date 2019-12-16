<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Exceptions;

use Exception;

class InvalidNamespaceException extends Exception
{
    public static function missingServiceNamespace()
    {
        return new static('A Service namespace must be defined in configuration.');
    }
}
