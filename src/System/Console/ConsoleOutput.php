<?php

namespace App\System\Console;

use App\System\Console\Interfaces\ConsoleOutputInterface;

final class ConsoleOutput implements ConsoleOutputInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * ConsoleOutput constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text . "\r\n";
    }
}