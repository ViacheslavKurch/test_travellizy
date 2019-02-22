<?php

namespace App\ParserContext\Domain\ValueObjects;

use App\ParserContext\Domain\Exceptions\ValueObjects\InvalidDomainException;

final class Domain
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $host;

    /**
     * Domain constructor.
     * @param string $domain
     * @throws InvalidDomainException
     */
    public function __construct(string $domain)
    {
        $this->validate($domain);

        $this->domain = $domain;
        $this->host = $host = parse_url($domain, PHP_URL_HOST);
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $domain
     * @throws InvalidDomainException
     */
    private function validate(string $domain): void
    {
        if (false === filter_var($domain, FILTER_VALIDATE_URL)) {
            throw new InvalidDomainException();
        }
    }
}