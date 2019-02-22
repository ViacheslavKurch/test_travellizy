<?php

namespace App\ParserContext\Domain\Services;

use App\ParserContext\Domain\ValueObjects\Domain;

interface GenerateReportServiceInterface
{
    /**
     * @param Domain $domain
     * @param array $urls
     * @return string
     */
    public function execute(Domain $domain, array $urls): string;
}