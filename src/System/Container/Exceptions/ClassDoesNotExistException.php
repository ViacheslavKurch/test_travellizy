<?php

namespace App\System\Container\Exceptions;

use Throwable;

class ClassDoesNotExistException extends \Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct(
            'Class ' . $message . ' does not exist',
            $code,
            $previous
        );
    }
}