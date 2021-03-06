<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class UpperCamelCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class UpperCamelCaseConverterType extends ConverterTypeBase
{

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        // Lower camel case always starts with lowercase.
        if ($string[0] !== strtoupper($string[0])) {
            return false;
        }

        $matches = [];
        preg_match_all('/([A-Z])|([a-z])/', $string, $matches);

        // If there is at least one uppercase letter
        // and one lowercase letter then true.
        return !empty(array_filter($matches[1])) && !empty(array_filter($matches[2]));
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        if (null === $pattern) {
            return ucfirst(strtolower($string));
        }

        $string = preg_replace_callback(
            $pattern,
            function ($matches) {
                return strtoupper(trim($matches[1], '_'));
            },
            $string
        );

        return ucfirst($string);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegExp(): ?string
    {
        return '/([A-Z])/';
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'UpperCamelCase';
    }
}
