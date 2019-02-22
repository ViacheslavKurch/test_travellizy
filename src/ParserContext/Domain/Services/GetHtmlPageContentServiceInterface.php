<?php

namespace App\ParserContext\Domain\Services;

use App\SharedKernel\Curl\Interfaces\ResponseInterface;

interface GetHtmlPageContentServiceInterface
{
    /**
     * @param string $url
     * @return ResponseInterface|null
     */
    public function execute(string $url): ?ResponseInterface;
}