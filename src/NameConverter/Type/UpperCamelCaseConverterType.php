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
        if ($string[0] !== strtoupper($string[0])) {
            return false;
        }

        $matches = [];
        preg_match_all('/([A-Z])/', $string, $matches);

        // If there is at least one uppercase letter then true.
        return empty($matches[0]);
    }

    /**
     * {@inheritDoc}
     */
    public function convert(string $string, string $pattern = null): string
    {
        $string = preg_replace_callback(
          $pattern,
          function ($matches) {
              return strtoupper($matches[1]);
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
    public static function getType(): string
    {
        return 'UpperCamelCase';
    }
}
