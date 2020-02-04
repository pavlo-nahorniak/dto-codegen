<?php

namespace App\Entity;

/**
 * Class Property.
 *
 * @package App\Entity
 */
final class Property
{

    /**
     * Property name.
     *
     * @var string
     */
    private $name;

    /**
     * Property type.
     *
     * @var string
     */
    private $type;

    /**
     * Defines array depth of property.
     *
     * @var int
     */
    private $arrayDepth;

    /**
     * Defines type of object the property is referenced to.
     *
     * @var string
     */
    private $objectTypeName;

    /**
     * Property constructor.
     *
     * @param string $name
     * @param string $type
     * @param int $arrayDepth
     * @param string $objectTypeName
     */
    public function __construct(string $name, string $type, int $arrayDepth, string $objectTypeName = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->arrayDepth = $arrayDepth;
        $this->objectTypeName = $objectTypeName;
    }

    /**
     * Gets a name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets a type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets an array depth.
     *
     * @return int
     */
    public function getArrayDepth()
    {
        return $this->arrayDepth;
    }

    /**
     * Checks if the property is object.
     *
     * @return bool
     */
    public function isObject()
    {
        return strpos($this->type, 'object') === 0;
    }

    /**
     * Gets a type of object the property is referenced to.
     *
     * If null equals to property name.
     *
     * @return string
     */
    public function getObjectTypeName()
    {
        return $this->objectTypeName ?? $this->name;
    }
}
