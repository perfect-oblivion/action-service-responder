<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Exceptions;

use Exception;

class InvalidNamespaceException extends Exception
{
    public static function missingValidationServiceNamespace()
    {
        return new static('A ValidationService namespace must be defined in configuration.');
    }
}
