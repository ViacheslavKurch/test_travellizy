<?php

namespace App\ParserContext\Domain\Services;

interface UrlNormalizeServiceInterface
{
    /**
     * @param string $domain
     * @param string $url
     * @return string
     */
    public function execute(string $domain, string $url): string;
}