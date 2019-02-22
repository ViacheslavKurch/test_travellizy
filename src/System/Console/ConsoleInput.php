<?php

namespace App\System\Console;

use App\System\Console\Interfaces\ConsoleInputInterface;
use App\System\Console\Exceptions\InvalidMethodException;
use App\System\Console\Exceptions\CommandNameIsRequiredException;

final class ConsoleInput implements ConsoleInputInterface
{
    /**
     * @var mixed
     */
    private $commandName;

    /**
     * @var array
     */
    private $arguments;

    /**
     * ConsoleInput constructor.
     * @param array|null $argv
     * @throws CommandNameIsRequiredException
     * @throws InvalidMethodException
     */
    public function __construct(?array $argv)
    {
        $this->validateInputData($argv);

        $this->commandName = $argv[1];
        $this->arguments = array_slice($argv, 2);
    }

    /**
     * @param array|null $argv
     * @throws CommandNameIsRequiredException
     * @throws InvalidMethodException
     */
    private function validateInputData(?array $argv): void
    {
        if (null === $argv) {
            throw new InvalidMethodException();
        }

        if (true === empty($argv[1])) {
            throw new CommandNameIsRequiredException();
        }
    }

    /**
     * @return string
     */
    public function getCommandName(): string
    {
        return $this->commandName;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}