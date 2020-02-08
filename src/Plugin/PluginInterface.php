<?php

namespace App\Plugin;

interface PluginInterface
{

    /**
     * Gets the plugin ID.
     *
     * @return string
     */
    public static function getPluginId(): string;
}
