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

    protected const PLUGINS_DIR = __DIR__ . '/Type';

    protected const PLUGIN_NAMESPACE = '\\App\\NameConverter\\Type\\';
}
