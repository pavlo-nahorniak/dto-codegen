<?php

namespace App\Container;

use App\FileSystem;
use App\Generator\GeneratorManager;
use App\NameConverter\ConverterManager;
use App\NameConverter\NameConverter;
use App\Parser\ParserManager;
use App\Renderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Container.
 *
 * @package App
 */
class Container implements ContainerInterface
{

    private const SERVICES = [
        'generator.manager' => [
            'class' => GeneratorManager::class,
        ],
        'parser.manager' => [
            'class' => ParserManager::class,
        ],
        'renderer' => [
            'class' => Renderer::class,
            'arguments' => ['@twig.environment', '@file_system'],
        ],
        'converter.manager' => [
            'class' => ConverterManager::class,
        ],
        'name_converter' => [
            'class' => NameConverter::class,
            'arguments' => ['@converter.manager'],
        ],
        'twig.filesystem_loader' => [
            'class' => FilesystemLoader::class,
            'arguments' => [
                [Renderer::TWIG_DEFAULT_TEMPLATES],
                Renderer::TWIG_ROOT_PATH,
            ],
        ],
        'twig.environment' => [
            'class' => Environment::class,
            'arguments' => ['@twig.filesystem_loader'],
        ],
        'file_system' => [
            'class' => FileSystem::class,
        ],
    ];

    private static $instance;

    private static $serviceInstances;

    /**
     * Disable public constructor.
     */
    private function __construct()
    {
    }

    /**
     * Gets an instance of container.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf(
                    'No entry was found for %s identifier.',
                    $id
                )
            );
        }

        if (!isset(self::$serviceInstances[$id])) {
            $this->createInstance($id);
        }

        return self::$serviceInstances[$id];
    }

    /**
     * {@inheritDoc}
     */
    public function has($id)
    {
        return isset($this->getServicesList()[$id]);
    }

    /**
     * Creates an instance of service by id.
     *
     * @param $id
     *
     * @return void
     * @throws \ReflectionException
     */
    private function createInstance($id)
    {
        $service = $this->getServicesList()[$id];

        if (empty($service['arguments'])) {
            $instance = new $service['class']();
            $this->addInstance($id, $instance);
            return;
        }

        $arguments = $service['arguments'];

        foreach ($arguments as $key => $arg) {
            if (is_string($arg) && strpos($arg, '@') === 0) {
                $serviceId = str_replace('@', '', $arg);
                // @ sign indicates that the string probably is service name
                // however it is not always true.
                if ($this->has($serviceId)) {
                    $arguments[$key] = $this->get($serviceId);
                }
            }
        }

        $reflection = new \ReflectionClass($service['class']);
        $instance = $reflection->newInstanceArgs($arguments);
        $this->addInstance($id, $instance);
    }

    /**
     * Shortcut function to add instance to static storage.
     *
     * @param $id
     * @param $instance
     */
    private function addInstance($id, $instance)
    {
        if (!is_array(self::$serviceInstances)) {
            self::$serviceInstances = [];
        }

        if (!isset(self::$serviceInstances[$id])) {
            self::$serviceInstances[$id] = $instance;
        }
    }

    /**
     * Gets a list of available services.
     *
     * @return array
     */
    private function getServicesList()
    {
        return self::SERVICES;
    }
}
