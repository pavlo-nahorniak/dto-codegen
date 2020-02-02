<?php

namespace App\NameConverter;

/**
 * Class ConverterManager.
 *
 * @package App\NameConverter
 */
class ConverterManager
{

    protected const CONVERTERS_DIR = __DIR__ . '/Type';

    protected const CONVERTER_NAMESPACE = '\\App\\NameConverter\\Type\\';

    /**
     * Map of all converters keyed by type.
     *
     * @var array
     */
    protected static $map = [];

    /**
     * ConverterManager constructor.
     */
    public function __construct()
    {
        $this->findAll();
    }

    /**
     * Gets converter types.
     *
     * @return array
     *   List of types.
     */
    public function getConverterTypes(): array
    {
        $values = array_keys(static::$map);
        return array_combine($values, $values);
    }

    /**
     * Gets an instance of converter.
     *
     * @param string $type
     *   Converter type.
     *
     * @return \App\NameConverter\ConverterTypeInterface
     *   Converter.
     */
    public function getConverter(string $type): ConverterTypeInterface
    {
        if (!isset(static::$map[$type])) {
            throw new \InvalidArgumentException(sprintf('Convert of type %s not found', $type));
        }

        return call_user_func(static::$map[$type] . '::getInstance');
    }

    /**
     * Checks a directory for all available converters.
     */
    private function findAll(): void
    {
        $dirIterator = new \DirectoryIterator(self::CONVERTERS_DIR);

        foreach ($dirIterator as $dir) {
            if (!$dir->isFile()) {
                continue;
            }

            $className = $dir->getFileInfo()->getBasename('.php');
            $fqcn = static::CONVERTER_NAMESPACE . $className;

            if (class_exists($fqcn)) {
                static::$map[call_user_func($fqcn . '::getType')] = $fqcn;
            }
        }
    }
}
