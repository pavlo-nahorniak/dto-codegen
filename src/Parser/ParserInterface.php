<?php

namespace App\Parser;

use App\Plugin\PluginInterface;

/**
 * Interface ParserInterface.
 *
 * @package App
 */
interface ParserInterface extends PluginInterface
{

    /**
     * Parses a data.
     *
     * @param mixed $data
     *   A data to parse.
     *
     * @return \App\Entity\ObjectEntity[]
     *   List of parsed objects.
     */
    public function parse($data);
}
