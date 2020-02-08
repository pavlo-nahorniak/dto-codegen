<?php

namespace App\Generator;

use App\Plugin\PluginInterface;

/**
 * Interface GeneratorInterface.
 *
 * @package App\Generator
 */
interface GeneratorInterface extends PluginInterface
{

    /**
     * Generates code based on object structure.
     *
     * @param \App\Entity\ObjectEntity[] $structure
     * @param string $namespace
     * @param array $configs
     */
    public function generate(array $structure, string $namespace, array $configs): void;
}
