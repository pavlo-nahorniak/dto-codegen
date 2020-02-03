<?php

namespace App\NameConverter;

use App\PluginInterface;

/**
 * Interface ConverterTypeInterface.
 *
 * @package App\NameConverter
 */
interface ConverterTypeInterface extends PluginInterface
{

    /**
     * Checks if the string is already converted to this type.
     *
     * @param string $string
     *   String to check.
     *
     * @return bool
     *   TRUE if already converted.
     */
    public function check(string $string): bool;

    /**
     * Converts the string to new case.
     *
     * @param string $string
     *   String to convert.
     * @param string $pattern
     *   Pattern to find letters that should be converted.
     *
     * @return string
     *   Converted string.
     */
    public function convert(string $string, string $pattern = null): string;

    /**
     * Gets a pattern fo finding stops, that should be converted.
     *
     * @return string
     *   RegExp Pattern.
     */
    public function getRegExp(): ?string;
}
