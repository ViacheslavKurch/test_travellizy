<?php

namespace App\System\Console\Exceptions;

class CommandNameIsRequiredException extends \Exception
{
    protected $message = 'Command name is required';
}