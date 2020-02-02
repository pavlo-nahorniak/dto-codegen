<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;

/**
 * Class LowerCamelCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class LowerCamelCaseConverterType extends ConverterTypeBase
{

    /**
     * Instance of the class.
     *
     * @var self
     */
    private static $instance;

    /**
     * Disable constructor.
     */
    private function __construct()
    {
    }

    /**
     * Singleton instance constructor.
     *
     * @return self
     *   The converter.
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            return new static();
        }

        return self::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function check(string $string): bool
    {
        // Lower camel case always starts with lowercase.
        if ($string[0] !== strtolower($string[0])) {
            return false;
        }

        $matches = [];
        preg_match_all('/([A-Z])/', $string, $matches);

        // If there is at least one uppercase letter then true.
        return !empty($matches[0]);
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
                return strtoupper(trim($matches[1], '_'));
            },
            $string
        );

        return lcfirst($string);
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
    public static function getType(): string
    {
        return 'lowerCamelCase';
    }
}
