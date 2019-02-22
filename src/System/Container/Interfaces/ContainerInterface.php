<?php

namespace App\System\Container\Interfaces;

interface ContainerInterface
{
    /**
     * @param string $serviceAlias
     * @return mixed
     */
    public function get(string $serviceAlias);
}