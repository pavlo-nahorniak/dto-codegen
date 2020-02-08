<?php

namespace App\Parser\Plugin;

use App\Entity\ObjectEntity;
use App\Entity\Property;
use App\Parser\ParserInterface;
use App\Plugin\PluginInterface;

/**
 * Class JsonParser.
 *
 * @package App\Parser
 */
class JsonParser implements ParserInterface
{

    private const DEFAULT_PROPERTY_TYPE = 'string';

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'json';
    }

    /**
     * {@inheritDoc}
     */
    public function parse($data)
    {
        $decodedData = json_decode($data, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Unable to decode json.');
        }

        if (empty($decodedData)) {
            throw new \InvalidArgumentException('JSON is empty. Nothing to parse.');
        }

        return $this->discoverAllObjects($decodedData);
    }

    /**
     *
     * @param string $name
     * @param \stdClass $data
     *
     * @return \App\Entity\ObjectEntity
     */
    private function createObject(string $name, \stdClass $data)
    {
        $object = new ObjectEntity($name);
        foreach ((array) $data as $key => $item) {
            $type = $this->discoverPropertyType($item);
            $arrayDepth = substr_count($type, '[]');

            $property = new Property($key, $type, $arrayDepth);
            $object->addProperty($property);
        }

        return $object;
    }

    /**
     * Discovers a type of given data.
     *
     * @param mixed $data
     *
     * @return string
     */
    private function discoverPropertyType($data): string
    {
        $types = [
          'bool',
          'int',
          'float',
          'string',
          'object',
        ];

        foreach ($types as $type) {
            $func = 'is_' . $type;
            if ($func($data)) {
                return $type;
            }
        }

        if (is_array($data)) {
            if (!empty($data[0])) {
                return $this->discoverPropertyType($data[0]) . '[]';
            } else {
                return 'array';
            }
        }

        return self::DEFAULT_PROPERTY_TYPE;
    }

    /**
     * Discovers all objects in data.
     *
     * @param \stdClass $data
     * @param string $mainObjectName
     *
     * @return \App\Entity\ObjectEntity[]
     */
    private function discoverAllObjects(\stdClass $data, string $mainObjectName = 'MainObject'): array
    {
        static $objects;

        if (!isset($objects)) {
            $objects = [];
        }

        $object = $this->createObject($mainObjectName, $data);
        $objects[$object->getName()] = $object;
        foreach ($object->getProperties() as $property) {
            if (!$property->isObject()) {
                continue;
            }

            // This object is already discovered, skip it.
            if (isset($objects[$property->getName()])) {
                continue;
            }

            $tmpData = $data->{$property->getName()};
            for ($i = 0; $i < $property->getArrayDepth(); $i++) {
                $tmpData = $tmpData[0];
            }

            $this->discoverAllObjects($tmpData, $property->getName());
        }

        return $objects;
    }
}
