<?php

namespace App\Entity;

/**
 * Class Object.
 *
 * @package App\Entity
 */
final class Object
{

    /**
     * Object name.
     *
     * @var string
     */
    private $name;

    /**
     * Object properties.
     *
     * @var \App\Entity\Property[]
     */
    private $properties;

    /**
     * Object constructor.
     *
     * @param string $name
     *   Object name.
     */
    public function __construct(string $name)
    {
        $this->name;
    }

    /**
     * Gets a properties.
     *
     * @return \App\Entity\Property[]
     *   Array of properties.
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Adds a property to the list.
     *
     * @param \App\Entity\Property $property
     *   A property to add.
     */
    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }
}
