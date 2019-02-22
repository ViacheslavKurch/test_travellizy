<?php

namespace App\ParserContext\Infrastructure\Services;

use App\ParserContext\Domain\ValueObjects\Domain;
use App\ParserContext\Domain\Services\GenerateReportServiceInterface;
use App\ParserContext\Domain\Exceptions\Services\ReportGenerationFailedException;

final class GenerateReportService implements GenerateReportServiceInterface
{
    private const EXTENSION_FILE = '.html';


    /**
     * @var string
     */
    private $reportsStoragePath;

    /**
     * @var string
     */
    private $reportTemplatePath;

    /**
     * GenerateReportService constructor.
     * @param string $reportsStoragePath
     * @param string $reportTemplatePath
     */
    public function __construct(string $reportsStoragePath, string $reportTemplatePath)
    {
        $this->reportsStoragePath = $reportsStoragePath;
        $this->reportTemplatePath = $reportTemplatePath;
    }

    /**
     * @param Domain $domain
     * @param array $urls
     * @return string
     * @throws ReportGenerationFailedException
     */
    public function execute(Domain $domain, array $urls): string
    {
        $filePath = $this->reportsStoragePath . $this->generateFileName($domain);

        $report = $this->generateReport([
            'domain' => $domain,
            'urls'   => $urls
        ]);

        $this->saveReport($report, $filePath);

        return $filePath;
    }

    /**
     * @param Domain $domain
     * @return string
     * @throws \Exception
     */
    private function generateFileName(Domain $domain): string
    {
        $dateTime = new \DateTime();
        $date = $dateTime->format('d.m.Y');

        return $domain->getHost() . '_' . $date . self::EXTENSION_FILE;
    }

    /**
     * @param array $data
     * @return string
     */
    private function generateReport(array $data = []): string
    {
        ob_start();
        extract($data);
        include($this->reportTemplatePath);
        $report = ob_get_contents();
        ob_end_clean();

        return $report;
    }

    /**
     * @param string $report
     * @param string $filePath
     * @throws ReportGenerationFailedException
     */
    private function saveReport(string $report, string $filePath): void
    {
        $handle = @fopen($filePath, 'w+');

        if (false === $handle) {
            throw new ReportGenerationFailedException('Report generation failed: cannot create file');
        }

        fwrite($handle, $report);
        fclose($handle);
    }
}