<?php

namespace App\SharedKernel\Curl\Interfaces;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return int
     */
    public function getLoadingTime(): int;

    /**
     * @return bool
     */
    public function contentTypeIsTextHtml(): bool;

    /**
     * @return bool
     */
    public function isSuccessful(): bool;
}