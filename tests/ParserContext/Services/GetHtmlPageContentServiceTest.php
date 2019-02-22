<?php

namespace Tests\ParserContext\Services;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\SharedKernel\Curl\Interfaces\CurlInterface;
use App\SharedKernel\Curl\Interfaces\ResponseInterface;
use App\ParserContext\Infrastructure\Services\GetHtmlPageContentService;

class GetHtmlPageContentServiceTest extends TestCase
{
    /** @var CurlInterface | MockObject */
    private $curlMock;

    /** @var ResponseInterface | MockObject */
    private $responseMock;

    /** @var GetHtmlPageContentService */
    private $service;

    public function setUp()
    {
        $this->curlMock = $this->createMock(CurlInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);

        $this->service = new GetHtmlPageContentService($this->curlMock);
    }

    public function testExecuteSuccess()
    {
        $url = 'http://some.domain.com';

        $this->curlMock
            ->expects(static::once())
            ->method('get')
            ->with($url)
            ->willReturn($this->responseMock);

        $this->responseMock
            ->expects(static::once())
            ->method('isSuccessful')
            ->willReturn(true);

        $this->responseMock
            ->expects(static::once())
            ->method('contentTypeIsTextHtml')
            ->willReturn(true);

        static::assertEquals(
            $this->responseMock,
            $this->service->execute($url)
        );
    }

    public function testExecuteIfResponseIsNotSuccessful()
    {
        $url = 'http://some.domain.com';

        $this->curlMock
            ->expects(static::once())
            ->method('get')
            ->with($url)
            ->willReturn($this->responseMock);

        $this->responseMock
            ->expects(static::once())
            ->method('isSuccessful')
            ->willReturn(false);

        $this->responseMock
            ->expects(static::never())
            ->method('contentTypeIsTextHtml');

        static::assertNull(
            $this->service->execute($url)
        );
    }

    public function testExecuteIfResponseContentTypeIsNotHtml()
    {
        $url = 'http://some.domain.com';

        $this->curlMock
            ->expects(static::once())
            ->method('get')
            ->with($url)
            ->willReturn($this->responseMock);

        $this->responseMock
            ->expects(static::once())
            ->method('isSuccessful')
            ->willReturn(true);

        $this->responseMock
            ->expects(static::once())
            ->method('contentTypeIsTextHtml')
            ->willReturn(false);

        static::assertNull(
            $this->service->execute($url)
        );
    }
}