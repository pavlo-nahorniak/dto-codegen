<?php

namespace App;

/**
 * Base PluginManager class.
 *
 * @package App
 */
abstract class PluginManagerBase implements PluginManagerInterface
{
    protected const PLUGINS_DIR = '';

    protected const PLUGIN_NAMESPACE = '';

    /**
     * Map of all converters keyed by type.
     *
     * @var array
     */
    protected $map = [];

    /**
     * ConverterManager constructor.
     */
    public function __construct()
    {
        $this->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailablePlugins(): array
    {
        $values = array_keys($this->map);
        return array_combine($values, $values);
    }

    /**
     * @inheritDoc
     */
    public function getPluginInstance(string $pluginId): PluginInterface
    {
        if (!isset($this->map[$pluginId])) {
            throw new \InvalidArgumentException(sprintf('Plugin of type %s not found', $pluginId));
        }

        return call_user_func($this->map[$pluginId] . '::getInstance');
    }

    /**
     * Checks a directory for all available converters.
     */
    protected function findAll(): void
    {
        $dirIterator = new \DirectoryIterator($this->getPluginsDirectory());

        foreach ($dirIterator as $dir) {
            if (!$dir->isFile()) {
                continue;
            }

            $className = $dir->getFileInfo()->getBasename('.php');
            $fqcn = $this->getPluginsNamespace() . $className;

            if (class_exists($fqcn)) {
                $this->map[call_user_func($fqcn . '::getPluginId')] = $fqcn;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getPluginsDirectory(): string
    {
        return static::PLUGINS_DIR;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPluginsNamespace(): string
    {
        return static::PLUGIN_NAMESPACE;
    }
}
