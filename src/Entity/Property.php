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
     * Property constructor.
     *
     * @param string $name
     * @param string $type
     * @param int $arrayDepth
     */
    public function __construct(string $name, string $type, int $arrayDepth)
    {
        $this->name = $name;
        $this->type = $type;
        $this->arrayDepth = $arrayDepth;
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
        return strpos($this->name, 'object') === 0;
    }
}
