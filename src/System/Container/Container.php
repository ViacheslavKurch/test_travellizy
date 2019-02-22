<?php

namespace App\System\Container;

use App\System\Container\Interfaces\ContainerInterface;
use App\System\Container\Exceptions\ServiceNotFoundException;
use App\System\Container\Exceptions\ClassDoesNotExistException;
use App\System\Container\Exceptions\ServiceAlreadyExistsException;

final class Container implements ContainerInterface
{
    private const SERVICE_ALIAS_PREFIX = '@';

    private const SERVICE_CLASS_NAME_KEY = 'class';

    private const SERVICE_ARGUMENTS_KEY = 'arguments';


    /**
     * @var array
     */
    private $services = [];

    /**
     * @var array
     */
    private $servicesStore = [];

    /**
     * Container constructor.
     * @param array $services
     * @throws ClassDoesNotExistException
     * @throws ServiceAlreadyExistsException
     */
    public function __construct(array $services)
    {
        foreach ($services as $alias => $config) {
            $this->register($alias, $config[self::SERVICE_CLASS_NAME_KEY], $config[self::SERVICE_ARGUMENTS_KEY]);
        }
    }

    /**
     * @param string $serviceAlias
     * @return object
     * @throws ServiceNotFoundException
     */
    public function get(string $serviceAlias)
    {
        if (false === $this->has($serviceAlias)) {
            throw new ServiceNotFoundException($serviceAlias);
        }

        if (false === isset($this->servicesStore[$serviceAlias])) {
            $this->servicesStore[$serviceAlias] = $this->resolve($serviceAlias);
        }

        return $this->servicesStore[$serviceAlias];
    }

    /**
     * @param string $serviceAlias
     * @param string $className
     * @param array $arguments
     * @throws ClassDoesNotExistException
     * @throws ServiceAlreadyExistsException
     */
    private function register(string $serviceAlias, string $className, array $arguments = []): void
    {
        if (true === $this->has($serviceAlias)) {
            throw new ServiceAlreadyExistsException($serviceAlias);
        }

        if (false === class_exists($className)) {
            throw new ClassDoesNotExistException($className);
        }

        $this->services[$serviceAlias] = [
            self::SERVICE_CLASS_NAME_KEY => $className,
            self::SERVICE_ARGUMENTS_KEY  => $arguments
        ];
    }

    /**
     * @param string $serviceAlias
     * @return bool
     */
    private function has(string $serviceAlias): bool
    {
        return isset($this->services[$serviceAlias]);
    }

    /**
     * @param string $serviceAlias
     * @return object
     * @throws ServiceNotFoundException
     */
    private function resolve(string $serviceAlias)
    {
        $serviceConfig = $this->services[$serviceAlias];

        $className = $serviceConfig[self::SERVICE_CLASS_NAME_KEY];

        $classArguments = [];

        foreach ($serviceConfig[self::SERVICE_ARGUMENTS_KEY] as $argument) {
            if (is_string($argument) && $argument[0] === self::SERVICE_ALIAS_PREFIX) {
                $classArguments[] = $this->get(ltrim($argument, self::SERVICE_ALIAS_PREFIX));
            } else {
                $classArguments[] = $argument;
            }
        }

        return new $className(...$classArguments);
    }
}