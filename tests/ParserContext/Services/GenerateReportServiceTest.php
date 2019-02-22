<?php

namespace Tests\ParserContext\Services;

use PHPUnit\Framework\TestCase;
use App\ParserContext\Domain\DTO\UrlInfoDTO;
use App\ParserContext\Domain\ValueObjects\Domain;
use App\ParserContext\Infrastructure\Services\GenerateReportService;
use App\ParserContext\Domain\Exceptions\Services\ReportGenerationFailedException;

class GenerateReportServiceTest extends TestCase
{
    /** @var string */
    private $reportsPath;

    /** @var string */
    private $reportTemplatePath;

    /** @var GenerateReportService */
    private $service;

    public function setUp()
    {
        $this->reportsPath = __DIR__ . '/temp/';

        if (true === file_exists($this->reportsPath)) {
            array_map('unlink', glob($this->reportsPath . "/*.*"));
        } else {
            mkdir($this->reportsPath);
        }

        $this->reportTemplatePath = __DIR__ . '/../../../src/ParserContext/Infrastructure/Resources/Views/report.php';

        $this->service = new GenerateReportService($this->reportsPath, $this->reportTemplatePath);
    }

    public function testReportTemplateFileExists()
    {
        static::assertTrue(file_exists($this->reportTemplatePath));
    }

    public function executeDataProvider()
    {
        return [
            [
                'domain'           => new Domain('https://w1c.ru/'),
                'expectedFileName' => 'w1c.ru_' . (new \DateTime())->format('d.m.Y') . '.html',
                'urls'             => [
                    new UrlInfoDTO('https://w1c.ru/page-1', 10, 0, 1),
                    new UrlInfoDTO('https://w1c.ru/page-2', 9, 0, 2),
                    new UrlInfoDTO('https://w1c.ru/page-3', 9, 0, 3)
                ]
            ]
        ];
    }

    /** @dataProvider executeDataProvider */
    public function testExecuteSuccess(Domain $domain, string $expectedFileName, array $urls)
    {
        $expectedFilePath = $this->reportsPath . $expectedFileName;

        $actualFilePath = $this->service->execute($domain, $urls);

        self::assertEquals($expectedFilePath, $actualFilePath);

        $report = file_get_contents($actualFilePath);

        foreach ($urls as $urlInfo) {
            /** @var UrlInfoDTO $urlInfo */
            self::assertContains($urlInfo->getUrl(), $report);
        }
    }

    public function testExecuteFailedCannotSaveReport()
    {
        rmdir($this->reportsPath);

        self::expectException(ReportGenerationFailedException::class);

        $this->service->execute(new Domain('http://some.domain.com'), []);
    }
}