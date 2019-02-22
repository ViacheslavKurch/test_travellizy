<?php

namespace App\System\Container\Exceptions;

use Throwable;

class ServiceAlreadyExistsException extends \Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct(
            'Service ' . $message . ' with same alias already exists',
            $code,
            $previous
        );
    }
}