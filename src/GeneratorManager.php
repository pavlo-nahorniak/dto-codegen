<?php

namespace App;

/**
 * Class GeneratorManager.
 *
 * @package App
 */
class GeneratorManager extends PluginManagerBase
{

    private const GENERATORS_DIR = __DIR__ . '/Generator';

    private const GENERATOR_NAMESPACE = '\\App\\Generator\\';

    /**
     * {@inheritDoc}
     */
    protected function getPluginsDirectory(): string
    {
        return self::GENERATORS_DIR;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPluginsNamespace(): string
    {
        return self::GENERATOR_NAMESPACE;
    }
}
