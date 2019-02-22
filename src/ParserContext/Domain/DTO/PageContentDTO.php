<?php

namespace App\ParserContext\Domain\DTO;

final class PageContentDTO
{
    /**
     * @var int
     */
    private $imagesCount;

    /**
     * @var array
     */
    private $links;

    /**
     * PageContentDTO constructor.
     * @param int $imagesCount
     * @param array $links
     */
    public function __construct(int $imagesCount, array $links)
    {
        $this->imagesCount = $imagesCount;
        $this->links = $links;
    }

    /**
     * @return int
     */
    public function getImagesCount(): int
    {
        return $this->imagesCount;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}