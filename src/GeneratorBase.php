<?php

namespace App;

use App\NameConverter\NameConverter;

abstract class GeneratorBase implements GeneratorInterface
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
     * Disable public constructor.
     *
     * @param \App\Renderer $renderer
     * @param \App\NameConverter\NameConverter $nameConverter
     */
    protected function __construct(Renderer $renderer, NameConverter $nameConverter)
    {
        $this->renderer = $renderer;
        $this->nameConverter = $nameConverter;
    }
}
