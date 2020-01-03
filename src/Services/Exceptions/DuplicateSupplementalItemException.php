<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Exceptions;

use Exception;

class DuplicateSupplementalItemException extends Exception
{
    public static function create(string $key)
    {
        return new static(sprintf("Can't merge [%s] into Supplementals. Already exists.", $key));
    }
}
