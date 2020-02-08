<?php

namespace App\Generator;

use App\NameConverter\NameConverter;
use App\Plugin\ContainerFactoryPluginInterface;
use App\Renderer;
use Psr\Container\ContainerInterface;

abstract class GeneratorBase implements GeneratorInterface, ContainerFactoryPluginInterface
{

    /**
     * @var \App\Renderer
     */
    protected $renderer;

    /**
     * @var
     */
    protected $nameConverter;

    /**
     * Constructor.
     *
     * @param \App\Renderer $renderer
     * @param \App\NameConverter\NameConverter $nameConverter
     */
    public function __construct(Renderer $renderer, NameConverter $nameConverter)
    {
        $this->renderer = $renderer;
        $this->nameConverter = $nameConverter;
    }

    /**
     * {@inheritDoc}
     */
    public static function create(ContainerInterface $container): ContainerFactoryPluginInterface
    {
        return new static(
            $container->get('renderer'),
            $container->get('name_converter')
        );
    }
}
