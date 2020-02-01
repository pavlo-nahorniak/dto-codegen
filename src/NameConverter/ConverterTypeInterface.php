<?php

namespace App\NameConverter;

/**
 * Interface ConverterTypeInterface.
 *
 * @package App\NameConverter
 */
interface ConverterTypeInterface
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
     * Prepares a string to convert from this type.
     *
     * @param string $string
     *   String to prepare.
     *
     * @return string
     *   Prepared string.
     */
    public function beforeConvert(string $string): string;

    /**
     * Gets a pattern fo finding stops, that should be converted.
     *
     * @return string
     *   RegExp Pattern.
     */
    public function getRegExp(): ?string;

    /**
     * Gets a type of converter.
     *
     * @return string
     *   Type.
     */
    public static function getType(): string;
}
