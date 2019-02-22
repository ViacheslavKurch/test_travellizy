<?php

namespace App\SharedKernel\Command\Interfaces;

use App\System\Console\Interfaces\ConsoleOutputInterface;

interface CommandInterface
{
    /**
     * @param array $arguments
     * @return ConsoleOutputInterface
     */
    public function execute(array $arguments): ConsoleOutputInterface;
}