<?php

namespace App\System\Application\Interfaces;

use App\System\Console\Interfaces\ConsoleInputInterface;
use App\System\Console\Interfaces\ConsoleOutputInterface;

interface ApplicationInterface
{
    /**
     * @param ConsoleInputInterface $consoleInput
     * @return ConsoleOutputInterface
     */
    public function handle(ConsoleInputInterface $consoleInput): ConsoleOutputInterface;
}