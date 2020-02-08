<?php

namespace App\Plugin;

use App\Container\Container;

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
     * Map of all plugins keyed by type.
     *
     * @var array
     */
    protected $map = [];

    /**
     * Map of all initiated plugins.
     *
     * @var \App\Plugin\PluginInterface[]
     */
    private $pluginInstances;

    /**
     * PluginManager constructor.
     */
    public function __construct()
    {
        $this->findAll();
        $this->pluginInstances = [];
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
     * {@inheritDoc}
     */
    public function getPluginInstance(string $pluginId): PluginInterface
    {
        if (!isset($this->map[$pluginId])) {
            throw new \InvalidArgumentException(sprintf('Plugin of type %s not found', $pluginId));
        }

        if (!isset($this->pluginInstances[$pluginId])) {
            if (in_array(ContainerFactoryPluginInterface::class, class_implements($this->map[$pluginId]))) {
                $instance = call_user_func($this->map[$pluginId] . '::create', $this->getContainer());
            } else {
                $instance = new $this->map[$pluginId]();
            }

            $this->pluginInstances[$pluginId] = $instance;
        }

        return $this->pluginInstances[$pluginId];
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

    /**
     * Gets an instance of container.
     *
     * @return \App\Container\Container
     */
    protected function getContainer()
    {
        return Container::getInstance();
    }
}
