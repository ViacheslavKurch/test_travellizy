<?php

namespace App\ParserContext\Infrastructure\Services;

use App\ParserContext\Domain\DTO\PageContentDTO;
use App\ParserContext\Domain\Services\ParseHtmlPageContentServiceInterface;

final class ParseHtmlPageContentService implements ParseHtmlPageContentServiceInterface
{
    private const ATTRIBUTE_LINK = 'href';

    private const TAG_LINK = 'a';

    private const TAG_IMAGES = 'img';


    /**
     * @var \DOMDocument
     */
    private $dom;

    /**
     * ParseHtmlPageContentService constructor.
     * @param \DOMDocument $dom
     */
    public function __construct(\DOMDocument $dom)
    {
        $this->dom = $dom;
    }

    /**
     * @param string $pageContent
     * @return PageContentDTO
     */
    public function execute(string $pageContent): PageContentDTO
    {
        @$this->dom->loadHTML($pageContent);

        return new PageContentDTO(
            $this->getImagesCount(),
            $this->getLinks()
        );
    }

    /**
     * @return int
     */
    private function getImagesCount(): int
    {
        $images = $this->dom->getElementsByTagName(self::TAG_IMAGES);

        return $images->length;
    }

    /**
     * @return array
     */
    private function getLinks(): array
    {
        $links = [];

        $anchors = $this->dom->getElementsByTagName(self::TAG_LINK);

        if ($anchors) {
            foreach ($anchors as $anchor) {
                $attributes = $anchor->attributes;

                foreach ($attributes as $attribute) {
                    if ($attribute->nodeName == self::ATTRIBUTE_LINK) {
                        $links[] = $attribute->nodeValue;
                    }
                }
            }
        }

        return $links;
    }
}