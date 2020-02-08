<?php

namespace App\Generator;

use App\Plugin\PluginManagerBase;

/**
 * Class GeneratorManager.
 *
 * @package App
 */
class GeneratorManager extends PluginManagerBase
{

    protected const PLUGINS_DIR = __DIR__ . '/Plugin';

    protected const PLUGIN_NAMESPACE = '\\App\\Generator\\Plugin\\';
}
