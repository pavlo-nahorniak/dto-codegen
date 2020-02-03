<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;
use App\PluginInterface;

/**
 * Class SnakeCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class SnakeCaseConverterType extends ConverterTypeBase
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
    public static function getInstance(): PluginInterface
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
