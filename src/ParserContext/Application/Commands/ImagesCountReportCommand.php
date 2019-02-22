<?php

namespace App\ParserContext\Application\Commands;

use InvalidArgumentException;
use App\System\Console\ConsoleOutput;
use App\ParserContext\Domain\ValueObjects\Domain;
use App\System\Console\Interfaces\ConsoleOutputInterface;
use App\SharedKernel\Command\Interfaces\CommandInterface;
use App\ParserContext\Domain\Services\GetDomainUrlsServiceInterface;
use App\ParserContext\Domain\Services\GenerateReportServiceInterface;
use App\ParserContext\Domain\Exceptions\ValueObjects\InvalidDomainException;

final class ImagesCountReportCommand implements CommandInterface
{
    /**
     * @var GetDomainUrlsServiceInterface
     */
    private $countImagesService;

    /**
     * @var GenerateReportServiceInterface
     */
    private $generateReportService;

    /**
     * ImagesCountReportCommand constructor.
     * @param GetDomainUrlsServiceInterface $countImagesService
     * @param GenerateReportServiceInterface $generateReportService
     */
    public function __construct(
        GetDomainUrlsServiceInterface $countImagesService,
        GenerateReportServiceInterface $generateReportService
    )
    {
        $this->countImagesService = $countImagesService;
        $this->generateReportService = $generateReportService;
    }

    /**
     * @param array $arguments
     * @return ConsoleOutputInterface
     */
    public function execute(array $arguments): ConsoleOutputInterface
    {
        $domain = current($arguments);

        if (false === $domain) {
            throw new InvalidArgumentException('Domain is required');
        }

        try {
            $domainValueObject = new Domain($domain);
        } catch (InvalidDomainException $invalidDomainException) {
            throw new InvalidArgumentException('The argument must be a valid domain');
        }

        $urls = $this->countImagesService->execute($domainValueObject);
        $reportFilePath = $this->generateReportService->execute($domainValueObject, $urls);

        return new ConsoleOutput('Path to report: ' . $reportFilePath);
    }
}