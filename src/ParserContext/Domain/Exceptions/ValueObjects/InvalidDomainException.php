<?php

namespace App\ParserContext\Domain\Exceptions\ValueObjects;

class InvalidDomainException extends \Exception
{
    protected $message = 'This domain is not valid';
}