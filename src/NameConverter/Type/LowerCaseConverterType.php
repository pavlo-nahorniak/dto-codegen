<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class LowerCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class LowerCaseConverterType extends ConverterTypeBase
{

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        return strpos($string, '_') === false
          && strtolower($string) === $string;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        return strtolower(str_replace('_', '', $string));
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'lowercase';
    }
}
