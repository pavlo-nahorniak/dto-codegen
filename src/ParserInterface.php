<?php

namespace App;

/**
 * Interface ParserInterface.
 *
 * @package App
 */
interface ParserInterface
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
