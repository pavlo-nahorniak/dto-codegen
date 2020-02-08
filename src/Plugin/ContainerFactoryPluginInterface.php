<?php

namespace App\Plugin;

use Psr\Container\ContainerInterface;

interface ContainerFactoryPluginInterface
{

    /**
     * Creates an instance of plugin.
     *
     * @param \Psr\Container\ContainerInterface $container
     *
     * @return static
     */
    public static function create(ContainerInterface $container): self;
}
