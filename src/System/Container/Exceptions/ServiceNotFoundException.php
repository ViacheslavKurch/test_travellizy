<?php

namespace App\System\Container\Exceptions;

use Throwable;

class ServiceNotFoundException extends \Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct(
            'Service ' . $message . ' not found',
            $code,
            $previous
        );
    }
}