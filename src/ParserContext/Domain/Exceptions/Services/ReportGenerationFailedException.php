<?php

namespace App\ParserContext\Domain\Exceptions\Services;

class ReportGenerationFailedException extends \Exception
{
    protected $message = 'Report generation failed';
}