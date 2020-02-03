<?php

namespace App;

interface PluginInterface
{

    /**
     * Gets an instance of the plugin.
     *
     * All plugins should implement Singleton pattern.
     *
     * @return self
     */
    public static function getInstance(): self;

    /**
     * Gets the plugin ID.
     *
     * @return string
     */
    public static function getPluginId(): string;
}
