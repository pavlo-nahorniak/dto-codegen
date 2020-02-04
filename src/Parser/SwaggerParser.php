<?php

namespace App\Parser;

use App\Entity\ObjectEntity;
use App\Entity\Property;
use App\ParserInterface;

/**
 * Class SwaggerParser.
 *
 * @package App\Parser
 */
class SwaggerParser implements ParserInterface
{

    private const DEF_NAMESPACE = '#/definitions/';

    private const SCALAR_TYPES = [
        'integer' => 'int',
        'number' => 'float',
        'string' => 'string',
        'boolean' => 'bool',
    ];

    /**
     * @inheritDoc
     */
    public function parse($data)
    {
        $decodedData = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Unable to decode json.');
        }

        if (empty($decodedData)) {
            throw new \InvalidArgumentException('JSON is empty. Nothing to parse.');
        }

        return $this->discoverAllObjects($decodedData['definitions']);
    }

    /**
     * Discovers all objects in data.
     *
     * @param array $data
     *
     * @return \App\Entity\ObjectEntity[]
     */
    private function discoverAllObjects(array $data): array
    {
        static $objects;

        if (!isset($objects)) {
            $objects = [];
        }

        foreach ($data as $objectName => $swaggerObject) {
            $object = $this->createObject($objectName, $swaggerObject['properties']);
            $objects[$object->getName()] = $object;
        }

        return $objects;
    }

    /**
     *
     * @param string $name
     * @param array $data
     *
     * @return \App\Entity\ObjectEntity
     */
    private function createObject(string $name, array $data)
    {
        $object = new ObjectEntity($name);
        foreach ($data as $key => $item) {
            $type = $this->discoverPropertyType($item);
            $arrayDepth = substr_count($type, '[]');
            $objectTypeName = $this->discoverPropertyObjectTypeName($item);

            $property = new Property($key, $type, $arrayDepth, $objectTypeName);
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
        if (isset($data['$ref'])) {
            return 'object';
        }

        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Property type could not be discovered!');
        }

        // Object with additionalProperties == associative array.
        if ($data['type'] == 'object' && isset($data['additionalProperties'])) {
            return $this->discoverPropertyType($data['additionalProperties']) . '[]';
        }

        if (isset(self::SCALAR_TYPES[$data['type']])) {
            return self::SCALAR_TYPES[$data['type']];
        }

        if ($data['type'] == 'array') {
            return $this->discoverPropertyType($data['items']) . '[]';
        }

        return $data['type'];
    }

    /**
     * Discovers a object name of given property data.
     *
     * @param array $propertyData
     *
     * @return string|null
     */
    private function discoverPropertyObjectTypeName(array $propertyData): ?string
    {
        if (isset($propertyData['$ref'])) {
            return str_replace('#/definitions/', '', $propertyData['$ref']);
        }

        if (isset($propertyData['type'])) {
            if ($propertyData['type'] == 'array') {
                return $this->discoverPropertyObjectTypeName($propertyData['items']);
            }

            if ($propertyData['type'] == 'object' && isset($propertyData['additionalProperties'])) {
                return $this->discoverPropertyObjectTypeName($propertyData['additionalProperties']);
            }
        }

        return null;
    }
}
