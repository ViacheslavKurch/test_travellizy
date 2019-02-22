<?php

namespace App\ParserContext\Infrastructure\Services;

use App\ParserContext\Domain\Services\UrlNormalizeServiceInterface;

final class UrlNormalizeService implements UrlNormalizeServiceInterface
{
    /**
     * @param string $domain
     * @param string $url
     * @return string
     */
    public function execute(string $domain, string $url): string
    {
        $fragment = parse_url($url, PHP_URL_FRAGMENT);
        $query = parse_url($url, PHP_URL_QUERY);
        $host = parse_url($url, PHP_URL_HOST);

        if (null === $host) {
            $url = rtrim($domain, '/') . $url;
        }

        $url = str_replace('#' . $fragment, '', $url);
        $url = str_replace('?' . $query, '', $url);

        return $url;
    }
}