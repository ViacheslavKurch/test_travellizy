<?php

namespace App\ParserContext\Infrastructure\Services;

use App\ParserContext\Domain\DTO\UrlInfoDTO;
use App\ParserContext\Domain\ValueObjects\Domain;
use App\ParserContext\Domain\Services\UrlNormalizeServiceInterface;
use App\ParserContext\Domain\Services\GetDomainUrlsServiceInterface;
use App\ParserContext\Domain\Services\GetHtmlPageContentServiceInterface;
use App\ParserContext\Domain\Services\ParseHtmlPageContentServiceInterface;

final class GetDomainUrlsService implements GetDomainUrlsServiceInterface
{
    private const DEFAULT_DEPTH = 1;


    /**
     * @var GetHtmlPageContentServiceInterface
     */
    private $getHtmlPageContentService;

    /**
     * @var ParseHtmlPageContentServiceInterface
     */
    private $parseHtmlPageContentService;

    /**
     * @var UrlNormalizeServiceInterface
     */
    private $urlNormalizeService;

    /** @var Domain */
    private $domain;

    /**
     * @var array
     */
    private $domainUrls = [];

    /**
     * GetDomainUrlsService constructor.
     * @param GetHtmlPageContentServiceInterface $getHtmlPageContentService
     * @param ParseHtmlPageContentServiceInterface $parseHtmlPageContentService
     * @param UrlNormalizeServiceInterface $urlNormalizeService
     */
    public function __construct(
        GetHtmlPageContentServiceInterface $getHtmlPageContentService,
        ParseHtmlPageContentServiceInterface $parseHtmlPageContentService,
        UrlNormalizeServiceInterface $urlNormalizeService
    ) {
        $this->getHtmlPageContentService = $getHtmlPageContentService;
        $this->parseHtmlPageContentService = $parseHtmlPageContentService;
        $this->urlNormalizeService = $urlNormalizeService;
    }

    /**
     * @param Domain $domain
     * @return array
     */
    public function execute(Domain $domain): array
    {
        $this->domain = $domain;

        $this->parseUrl($domain->getDomain());
        $this->sortUrls();

        return $this->domainUrls;
    }

    /**
     * @param string $url
     * @param int $depth
     */
    private function parseUrl(string $url, int $depth = self::DEFAULT_DEPTH): void
    {
        $url = $this->urlNormalizeService->execute($this->domain->getDomain(), $url);

        if (false !== $this->urlMustBeParsed($url)) {
            $response = $this->getHtmlPageContentService->execute($url);

            if (null !== $response) {
                $pageDTO = $this->parseHtmlPageContentService->execute($response->getContent());

                $this->domainUrls[$url] = new UrlInfoDTO(
                    $url,
                    $pageDTO->getImagesCount(),
                    $response->getLoadingTime(),
                    $depth
                );

                foreach ($pageDTO->getLinks() as $linkUrl) {
                    $this->parseUrl($linkUrl, $depth + 1);
                }
            }
        }
    }

    /**
     * @param string $url
     * @return bool
     */
    private function urlMustBeParsed(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);

        return false === isset($this->domainUrls[$url]) && $host == $this->domain->getHost();
    }

    private function sortUrls(): void
    {
        usort($this->domainUrls, function (UrlInfoDTO $url1, UrlInfoDTO $url2) {
            return $url1->getImagesCounter() < $url2->getImagesCounter();
        });
    }
}