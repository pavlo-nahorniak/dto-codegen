<?php

namespace App\NameConverter;

/**
 * Class ConverterTypeBase.
 *
 * @package App\NameConverter\Type
 */
abstract class ConverterTypeBase implements ConverterTypeInterface
{

    /**
     * {@inheritDoc}
     */
    public function getRegExp(): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeConvert(string $string): string
    {
        return $string;
    }
}
