<?php

namespace App\NameConverter;

use App\PluginManagerBase;

/**
 * Class ConverterManager.
 *
 * @package App\NameConverter
 */
class ConverterManager extends PluginManagerBase
{

    private const CONVERTERS_DIR = __DIR__ . '/Type';

    private const CONVERTER_NAMESPACE = '\\App\\NameConverter\\Type\\';

    /**
     * {@inheritDoc}
     */
    protected function getPluginsDirectory(): string
    {
        return self::CONVERTERS_DIR;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPluginsNamespace(): string
    {
        return self::CONVERTER_NAMESPACE;
    }
}
