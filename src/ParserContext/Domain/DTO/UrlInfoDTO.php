<?php

namespace App\ParserContext\Domain\DTO;

final class UrlInfoDTO
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $imagesCounter;

    /**
     * @var int
     */
    private $loadingTime;

    /**
     * @var int
     */
    private $depth;

    /**
     * UrlInfoDTO constructor.
     * @param string $url
     * @param int $imagesCounter
     * @param int $loadingTime
     * @param int $depth
     */
    public function __construct(string $url, int $imagesCounter, int $loadingTime, int $depth)
    {
        $this->url = $url;
        $this->imagesCounter = $imagesCounter;
        $this->loadingTime = $loadingTime;
        $this->depth = $depth;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getImagesCounter(): int
    {
        return $this->imagesCounter;
    }

    /**
     * @return int
     */
    public function getLoadingTime(): int
    {
        return $this->loadingTime;
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }
}