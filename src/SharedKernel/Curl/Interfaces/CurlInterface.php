<?php

namespace App\SharedKernel\Curl\Interfaces;

interface CurlInterface
{
    /**
     * @param string $url
     * @return ResponseInterface
     */
    public function get(string $url): ResponseInterface;
}