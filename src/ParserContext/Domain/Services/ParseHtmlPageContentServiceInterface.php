<?php

namespace App\ParserContext\Domain\Services;

use App\ParserContext\Domain\DTO\PageContentDTO;

interface ParseHtmlPageContentServiceInterface
{
    /**
     * @param string $pageContent
     * @return PageContentDTO
     */
    public function execute(string $pageContent): PageContentDTO;
}