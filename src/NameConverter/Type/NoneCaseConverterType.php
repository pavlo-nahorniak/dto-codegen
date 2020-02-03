<?php

namespace App\NameConverter\Type;

use App\NameConverter\ConverterTypeBase;
use App\PluginInterface;

/**
 * Class NoneConverterType.
 *
 * @package App\NameConverter\Type
 */
class NoneCaseConverterType extends ConverterTypeBase
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
