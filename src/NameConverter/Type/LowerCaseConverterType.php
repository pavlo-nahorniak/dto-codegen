<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;
use App\PluginInterface;

/**
 * Class LowerCaseConverterType.
 *
 * @package App\NameConverter\Type
 */
class LowerCaseConverterType extends ConverterTypeBase
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
