<?php

namespace App\ParserContext\Domain\Services;

use App\ParserContext\Domain\ValueObjects\Domain;

interface GetDomainUrlsServiceInterface
{
    /**
     * @param Domain $domain
     * @return array
     */
    public function execute(Domain $domain): array;
}