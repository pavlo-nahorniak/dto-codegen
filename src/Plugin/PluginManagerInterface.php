<?php

namespace App\Plugin;

interface PluginManagerInterface
{

    /**
     * Gets an instance of the plugin.
     *
     * @param string $pluginId
     *
     * @return \App\Plugin\PluginInterface
     */
    public function getPluginInstance(string $pluginId): PluginInterface;

    /**
     * Gets available plugin ids.
     *
     * @return string[]
     */
    public function getAvailablePlugins(): array;
}
