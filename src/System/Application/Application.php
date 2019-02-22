<?php

namespace App\System\Application;

use App\System\Container\Interfaces\ContainerInterface;
use App\System\Console\Interfaces\ConsoleInputInterface;
use App\System\Console\Interfaces\ConsoleOutputInterface;
use App\SharedKernel\Commands\Interfaces\CommandInterface;
use App\System\Application\Interfaces\ApplicationInterface;

final class Application implements ApplicationInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ConsoleInputInterface $consoleInput
     * @return ConsoleOutputInterface
     */
    public function handle(ConsoleInputInterface $consoleInput): ConsoleOutputInterface
    {
        /** @var CommandInterface $command */
        $command = $this->container->get($consoleInput->getCommandName());

        return $command->execute($consoleInput->getArguments());
    }
}