<?php

namespace App\System\Console\Interfaces;

interface ConsoleInputInterface
{
    /**
     * @return string
     */
    public function getCommandName(): string;

    /**
     * @return array
     */
    public function getArguments(): array;
}