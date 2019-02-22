<?php

namespace Tests\ParserContext\Services;

use PHPUnit\Framework\TestCase;
use App\SharedKernel\Curl\Response;
use App\ParserContext\Domain\DTO\UrlInfoDTO;
use PHPUnit\Framework\MockObject\MockObject;
use App\ParserContext\Domain\DTO\PageContentDTO;
use App\ParserContext\Domain\ValueObjects\Domain;
use App\ParserContext\Domain\Services\UrlNormalizeServiceInterface;
use App\ParserContext\Infrastructure\Services\GetDomainUrlsService;
use App\ParserContext\Domain\Services\GetHtmlPageContentServiceInterface;
use App\ParserContext\Domain\Services\ParseHtmlPageContentServiceInterface;

class GetDomainUrlsServiceTest extends TestCase
{
    /** @var MockObject | GetHtmlPageContentServiceInterface */
    private $getHtmlPageContentServiceMock;

    /** @var MockObject | ParseHtmlPageContentServiceInterface */
    private $parseHtmlPageContentServiceMock;

    /** @var MockObject | UrlNormalizeServiceInterface */
    private $urlNormalizeServiceMock;

    /** @var GetDomainUrlsService */
    private $service;

    public function setUp()
    {
        $this->getHtmlPageContentServiceMock = $this->createMock(GetHtmlPageContentServiceInterface::class);
        $this->parseHtmlPageContentServiceMock = $this->createMock(ParseHtmlPageContentServiceInterface::class);
        $this->urlNormalizeServiceMock = $this->createMock(UrlNormalizeServiceInterface::class);

        $this->service = new GetDomainUrlsService(
            $this->getHtmlPageContentServiceMock,
            $this->parseHtmlPageContentServiceMock,
            $this->urlNormalizeServiceMock
        );
    }

    public function testExecuteSuccess()
    {
        $url = 'http://some.domain.com';
        $domain = new Domain($url);

        $response = new Response('content', 0, 'text/html', 200);
        $pageDTO = new PageContentDTO(1, []);

        $expectedResult = [
            new UrlInfoDTO(
                $url,
                $pageDTO->getImagesCount(),
                $response->getLoadingTime(),
                1
            )
        ];

        $this->urlNormalizeServiceMock
            ->expects(static::once())
            ->method('execute')
            ->with($url, $url)
            ->willReturn($url);

        $this->getHtmlPageContentServiceMock
            ->expects(static::once())
            ->method('execute')
            ->willReturn($response);

        $this->parseHtmlPageContentServiceMock
            ->expects(static::once())
            ->method('execute')
            ->with($response->getContent())
            ->willReturn($pageDTO);

        static::assertEquals($expectedResult, $this->service->execute($domain));
    }

    public function testExecuteWithDepth()
    {
        $url = 'http://some.domain.com';

        $pages = [
            'root'       => [
                'url'      => 'http://some.domain.com',
                'response' => new Response('content', 0, 'text/html', 200),
                'pageDTO'  => new PageContentDTO(1, ['http://some.domain.com/page-1', 'http://some.domain.com/page-2']),
            ],
            'firstPage'  => [
                'url'      => 'http://some.domain.com/page-1',
                'response' => new Response('content', 0, 'text/html', 200),
                'pageDTO'  => new PageContentDTO(2, []),
            ],
            'secondPage' => [
                'url'      => 'http://some.domain.com/page-2',
                'response' => new Response('content', 0, 'text/html', 200),
                'pageDTO'  => new PageContentDTO(0, ['http://some.domain.com/page-3']),
            ],
            'thirdPage'  => [
                'url'      => 'http://some.domain.com/page-3',
                'response' => new Response('content', 0, 'text/html', 200),
                'pageDTO'  => new PageContentDTO(4, ['http://some.domain.com/page-2']),
            ],
        ];

        $expectedResult = [
            new UrlInfoDTO('http://some.domain.com/page-3', 4, 0, 3),
            new UrlInfoDTO('http://some.domain.com/page-1', 2, 0, 2),
            new UrlInfoDTO('http://some.domain.com', 1, 0, 1),
            new UrlInfoDTO('http://some.domain.com/page-2', 0, 0, 2),
        ];

        /** Root url */
        $this->urlNormalizeServiceMock
            ->expects(static::at(0))
            ->method('execute')
            ->with($url, $pages['root']['url'])
            ->willReturn($pages['root']['url']);

        $this->getHtmlPageContentServiceMock
            ->expects(static::at(0))
            ->method('execute')
            ->with($pages['root']['url'])
            ->willReturn($pages['root']['response']);

        $this->parseHtmlPageContentServiceMock
            ->expects(static::at(0))
            ->method('execute')
            ->with($pages['root']['response']->getContent())
            ->willReturn($pages['root']['pageDTO']);

        /** First child page url */
        $this->urlNormalizeServiceMock
            ->expects(static::at(1))
            ->method('execute')
            ->with($url, $pages['firstPage']['url'])
            ->willReturn($pages['firstPage']['url']);

        $this->getHtmlPageContentServiceMock
            ->expects(static::at(1))
            ->method('execute')
            ->with($pages['firstPage']['url'])
            ->willReturn($pages['firstPage']['response']);

        $this->parseHtmlPageContentServiceMock
            ->expects(static::at(1))
            ->method('execute')
            ->with($pages['firstPage']['response']->getContent())
            ->willReturn($pages['firstPage']['pageDTO']);

        /** Second child page url */
        $this->urlNormalizeServiceMock
            ->expects(static::at(2))
            ->method('execute')
            ->with($url, $pages['secondPage']['url'])
            ->willReturn($pages['secondPage']['url']);

        $this->getHtmlPageContentServiceMock
            ->expects(static::at(2))
            ->method('execute')
            ->with($pages['secondPage']['url'])
            ->willReturn($pages['secondPage']['response']);

        $this->parseHtmlPageContentServiceMock
            ->expects(static::at(2))
            ->method('execute')
            ->with($pages['secondPage']['response']->getContent())
            ->willReturn($pages['secondPage']['pageDTO']);

        /** Third child page url */
        $this->urlNormalizeServiceMock
            ->expects(static::at(3))
            ->method('execute')
            ->with($url, $pages['thirdPage']['url'])
            ->willReturn($pages['thirdPage']['url']);

        $this->getHtmlPageContentServiceMock
            ->expects(static::at(3))
            ->method('execute')
            ->with($pages['thirdPage']['url'])
            ->willReturn($pages['thirdPage']['response']);

        $this->parseHtmlPageContentServiceMock
            ->expects(static::at(3))
            ->method('execute')
            ->with($pages['thirdPage']['response']->getContent())
            ->willReturn($pages['thirdPage']['pageDTO']);

        static::assertEquals($expectedResult, $this->service->execute(new Domain($url)));
    }
}