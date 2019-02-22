<?php

namespace Tests\ParserContext\Services;

use App\ParserContext\Domain\DTO\PageContentDTO;
use App\ParserContext\Infrastructure\Services\ParseHtmlPageContentService;
use PHPUnit\Framework\TestCase;

class ParseHtmlPageContentServiceTest extends TestCase
{
    /** @var ParseHtmlPageContentService */
    private $service;

    public function setUp()
    {
        $this->service = new ParseHtmlPageContentService(new \DOMDocument());
    }

    public function testExecute()
    {
        $content = '<a href="/test"></a><img src="" alt=""><img src="" alt="">';

        $expectedResult = new PageContentDTO(2, ['/test']);

        static::assertEquals(
            $expectedResult,
            $this->service->execute($content)
        );
    }
}