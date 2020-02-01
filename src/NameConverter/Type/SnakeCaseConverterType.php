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
        return strpos($string, '_') === false
          && (strtolower($string) === $string || strtoupper($string) === $string);
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        return preg_replace_callback(
          $pattern,
          function ($matches) {
              return '_' . $matches[1];
          },
          $string
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getRegExp(): string
    {
        return '/_([A-Za-z])/';
    }

    /**
     * {@inheritDoc}
     */
    public function beforeConvert(string $string): string
    {
        return str_replace('_', '', $string);
    }

    /**
     * {@inheritDoc}
     */
    public static function getType(): string
    {
        return 'snake_case';
    }
}
