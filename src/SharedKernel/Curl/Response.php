<?php

namespace App\SharedKernel\Curl;

use App\SharedKernel\Curl\Interfaces\ResponseInterface;

final class Response implements ResponseInterface
{
    private const SUCCESS_STATUS_CODE = 200;

    private const CONTENT_TYPE_TEXT_HTML = 'text/html';


    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $loadingTime;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * Response constructor.
     * @param string $content
     * @param int $loadingTime
     * @param string $contentType
     * @param int $statusCode
     */
    public function __construct(
        string $content,
        int $loadingTime,
        string $contentType,
        int $statusCode
    )
    {
        $this->content = $content;
        $this->loadingTime = $loadingTime;
        $this->contentType = $contentType;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getLoadingTime(): int
    {
        return $this->loadingTime;
    }

    /**
     * @return bool
     */
    public function contentTypeIsTextHtml(): bool
    {
        list($contentType, ) = explode(';', $this->contentType);

        return self::CONTENT_TYPE_TEXT_HTML === $contentType;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return self::SUCCESS_STATUS_CODE === $this->statusCode;
    }
}