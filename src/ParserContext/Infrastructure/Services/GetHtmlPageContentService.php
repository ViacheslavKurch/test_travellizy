<?php

namespace App\ParserContext\Infrastructure\Services;

use App\SharedKernel\Curl\Interfaces\CurlInterface;
use App\SharedKernel\Curl\Interfaces\ResponseInterface;
use App\ParserContext\Domain\Services\GetHtmlPageContentServiceInterface;

final class GetHtmlPageContentService implements GetHtmlPageContentServiceInterface
{
    /**
     * @var CurlInterface
     */
    private $curl;

    /**
     * GetHtmlPageContentService constructor.
     * @param CurlInterface $curl
     */
    public function __construct(CurlInterface $curl)
    {
        $this->curl = $curl;
    }

    /**
     * @param string $url
     * @return ResponseInterface|null
     */
    public function execute(string $url): ?ResponseInterface
    {
        $response = $this->curl->get($url);

        $responseIsValid = true === $response->isSuccessful() && true === $response->contentTypeIsTextHtml();

        return $responseIsValid ? $response : null;
    }
}