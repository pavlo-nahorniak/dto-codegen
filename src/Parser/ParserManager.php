<?php

namespace App\Parser;

use App\Plugin\PluginManagerBase;

/**
 * Class ParserManager.
 *
 * @package App
 */
class ParserManager extends PluginManagerBase
{

    protected const PLUGINS_DIR = __DIR__ . '/Plugin';

    protected const PLUGIN_NAMESPACE = '\\App\\Parser\\Plugin\\';
}
