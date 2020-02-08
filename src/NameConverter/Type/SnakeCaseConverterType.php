<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class SnakeCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class SnakeCaseConverterType extends ConverterTypeBase
{

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        return strpos($string, '_') !== false;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        if (null === $pattern) {
            return strtolower($string);
        }

        $string = preg_replace_callback(
            $pattern,
            function ($matches) {
                return '_' . strtolower($matches[1]);
            },
            $string
        );

        return trim($string, '_');
    }

    /**
     * {@inheritDoc}
     */
    public function getRegExp(): string
    {
        return '/(_[A-Za-z])/';
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'snake_case';
    }
}
