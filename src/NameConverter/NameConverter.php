<?php

namespace App\NameConverter;

/**
 * Class NameConverter.
 *
 * @package App\NameConverter
 */
class NameConverter
{

    /**
     * Converter manager.
     *
     * @var \App\NameConverter\ConverterManager
     */
    protected $converterManager;

    /**
     * NameConverter constructor.
     *
     * @param \App\NameConverter\ConverterManager $converterManager
     */
    public function __construct(ConverterManager $converterManager)
    {
        $this->converterManager = $converterManager;
    }

    /**
     * Converts a name to a given case.
     *
     * @param string $name
     * @param string $type
     *
     * @return string
     */
    public function convert(string $name, string $type = 'lowercase'): string
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name should not be an empty string.');
        }

        $converterTypes = $this->converterManager->getAvailablePlugins();

        if (!in_array($type, $converterTypes)) {
            throw new \InvalidArgumentException(
                'Type should be one of ' . implode(', ', $converterTypes)
            );
        }

        // Unset type to which we are going to convert.
        unset($converterTypes[$type]);

        // None is a special converter that needed only to ignore converting at all.
        unset($converterTypes['none']);

        /** @var \App\NameConverter\ConverterTypeInterface[] $possibleTypes */
        $possibleTypes = [];
        foreach ($converterTypes as $converterType) {
            $converter = $this->converterManager->getPluginInstance($converterType);

            if ($converter->check($name)) {
                $tmpType = $converter::getPluginId();
                $possibleTypes[$tmpType] = $converter;
            }
        }

        // Nothing to convert, string already in correct type.
        if (empty($possibleTypes)) {
            return $name;
        }

        $mainConverter = $this->converterManager->getPluginInstance($type);
        // In general we need only one `beforeConvert` and one `convert`
        // foreach is needed in case when we have issues with namings
        // when multiple types are in use.
        foreach ($possibleTypes as $possibleType) {
            $name = $mainConverter->convert($name, $possibleType->getRegExp());
        }

        return $name;
    }
}
