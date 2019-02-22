<?php

namespace Tests\ParserContext\Services;

use PHPUnit\Framework\TestCase;
use App\ParserContext\Infrastructure\Services\UrlNormalizeService;

class UrlNormalizeServiceTest extends TestCase
{
    public function urlsDataProvider()
    {
        return [
            'emptyHost_case1'    => [
                'domain'   => 'http://some.domain.com',
                'url'      => '/test',
                'expected' => 'http://some.domain.com/test',
            ],
            'emptyHost_case2'    => [
                'domain'   => 'http://some.domain.com/',
                'url'      => '/test',
                'expected' => 'http://some.domain.com/test',
            ],
            'hostWithHash_case1' => [
                'domain'   => 'http://some.domain.com',
                'url'      => 'http://some.domain.com/page#hash',
                'expected' => 'http://some.domain.com/page',
            ],
            'hostWithHash_case2' => [
                'domain'   => 'http://some.domain.com',
                'url'      => 'http://some.domain.com/page#',
                'expected' => 'http://some.domain.com/page',
            ],
            'hostWithGetParams'  => [
                'domain'   => 'http://some.domain.com',
                'url'      => 'http://some.domain.com/page/?test=1&test=2',
                'expected' => 'http://some.domain.com/page/',
            ],
        ];
    }

    /** @dataProvider urlsDataProvider */
    public function testExecute($domain, $url, $expectedResult)
    {
        $service = new UrlNormalizeService();

        static::assertEquals(
            $expectedResult,
            $service->execute($domain, $url)
        );
    }
}