<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class UpperCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class UpperCaseConverterType extends ConverterTypeBase
{

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        return strpos($string, '_') === false
          && strtoupper($string) === $string;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        return strtoupper(str_replace('_', '', $string));
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'UPPERCASE';
    }
}
