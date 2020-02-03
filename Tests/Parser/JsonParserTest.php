<?php

namespace App\Tests\Parser;

use App\Parser\JsonParser;
use PHPUnit\Framework\TestCase;

class JsonParserTest extends TestCase
{

    private const TEST_DATA = [
        'string' => 'string',
        'string_number' => '1',
        'int' => 1,
        'float' => 1.1,
        'bool' => true,
        'null' => null,
        'sub_object' => [
            'string' => 'string',
            'string_number' => '1',
            'int' => 1,
            'float' => 1.1,
            'bool' => true,
            'array_int' => [
                1,
                2,
                3,
            ],
        ],
        'multidimensional_array_string' => [
            [
                'foo',
                'bar',
                'baz',
            ],
        ],
        'multidimensional_array_object' => [
            [
                [
                    'bool' => false,
                ],
                [
                    'bool' => false,
                ],
            ],
        ],
    ];

    private const RESULT_DATA_OBJECTS = [
        'MainObject' => [
            'string' => 'string',
            'string_number' => 'string',
            'int' => 'int',
            'float' => 'float',
            'bool' => 'bool',
            'null' => 'string',
            'sub_object' => 'object',
            'multidimensional_array_string' => 'string[][]',
            'multidimensional_array_object' => 'object[][]',
        ],
        'sub_object' => [
            'string' => 'string',
            'string_number' => 'string',
            'int' => 'int',
            'float' => 'float',
            'bool' => 'bool',
            'array_int' => 'int[]',
        ],
        'multidimensional_array_object' => [
            'bool' => 'bool',
        ],
    ];

    private const RESULT_DATA_ARRAY_DEPTH = [
        'multidimensional_array_string' => 2,
        'multidimensional_array_object' => 2,
        'array_int' => 1,
    ];

    /**
     * @var \App\Parser\JsonParser
     */
    private $jsonParser;

    protected function setUp(): void
    {
        $this->jsonParser = new JsonParser();
    }

    public function testParse()
    {
        $json = json_encode(self::TEST_DATA);
        $objects = $this->jsonParser->parse($json);

        $this->assertCount(3, $objects);

        foreach ($objects as $object) {
            $this->assertTrue(
                isset(self::RESULT_DATA_OBJECTS[$object->getName()]),
                sprintf(
                    'Object name \'%s\' was not parsed!',
                    $object->getName()
                )
            );

            foreach ($object->getProperties() as $property) {
                // Test if property was successfully parsed.
                $this->assertTrue(
                    isset(self::RESULT_DATA_OBJECTS[$object->getName()][$property->getName()]),
                    sprintf(
                        'Object property \'%s\' was not parsed on object \'%s\'!',
                        $property->getName(),
                        $object->getName()
                    )
                );

                // Test property types.
                $expectedPropertyType = self::RESULT_DATA_OBJECTS[$object->getName()][$property->getName()];
                $this->assertEquals(
                    $expectedPropertyType,
                    $property->getType(),
                    sprintf(
                        'Object property \'%s\' was not correctly parsed on object \'%s\'! Type should be \'%s\' but \'%s\' given',
                        $property->getName(),
                        $object->getName(),
                        $expectedPropertyType,
                        $property->getType()
                    )
                );

                // Test property array depth.
                $expectedArrayDepth = self::RESULT_DATA_ARRAY_DEPTH[$property->getName()] ?? 0;
                $this->assertEquals(
                    $expectedArrayDepth,
                    $property->getArrayDepth(),
                    sprintf(
                        'Object property \'%s\' was not correctly parsed on object \'%s\'! ArrayDepth should be \'%i\' but \'%i\' given',
                        $property->getName(),
                        $object->getName(),
                        $expectedArrayDepth,
                        $property->getArrayDepth()
                    )
                );

                // Test property isObject flag.
                $expectedIsObject = isset(self::RESULT_DATA_OBJECTS[$property->getName()]);
                $this->assertEquals(
                    $expectedIsObject,
                    $property->isObject(),
                    sprintf(
                        'Object property \'%s\' was not correctly parsed on object \'%s\'! isObject should return \'%s\' but \'%s\' given',
                        $property->getName(),
                        $object->getName(),
                        $expectedIsObject,
                        $property->isObject()
                    )
                );
            }
        }
    }
}
