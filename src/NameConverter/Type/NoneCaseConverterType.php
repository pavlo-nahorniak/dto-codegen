<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class NoneConverterType.
 *
 * @package App\NameConverter\Type
 */
class NoneCaseConverterType extends ConverterTypeBase
{

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        // There is no rules, it always none.
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        return $string;
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'none';
    }
}
