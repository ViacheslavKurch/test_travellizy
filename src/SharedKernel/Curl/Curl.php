<?php

namespace App\SharedKernel\Curl;

use App\SharedKernel\Curl\Interfaces\CurlInterface;
use App\SharedKernel\Curl\Interfaces\ResponseInterface;

final class Curl implements CurlInterface
{
    private const DEFAULT_CONNECT_TIMEOUT = 5;

    private const DEFAULT_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    /**
     * @param string $url
     * @return ResponseInterface
     */
    public function get(string $url): ResponseInterface
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::DEFAULT_CONNECT_TIMEOUT);
        curl_setopt($ch, CURLOPT_USERAGENT, self::DEFAULT_USER_AGENT);

        $content = curl_exec($ch);
        $loadingTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return new Response($content, $loadingTime, $contentType, $statusCode);
    }
}