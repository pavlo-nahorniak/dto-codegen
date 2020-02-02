<?php

namespace App\Tests\NameConverter;

use App\NameConverter\ConverterManager;
use App\NameConverter\NameConverter;
use PHPUnit\Framework\TestCase;

class NameConverterTest extends TestCase
{

    private const TEST_CASES = [
        'none' => [
            [
                'before' => 'lowercase',
                'after' => 'lowercase',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'UPPERCASE',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'lowerCamelCase',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'UpperCamelCase',
            ],
            [
                'before' => 'snake_case',
                'after' => 'snake_case',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'noneCase_fooBar',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'NoneCase_fooBar',
            ],
        ],
        'lowercase' => [
            [
                'before' => 'lowercase',
                'after' => 'lowercase',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'uppercase',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'lowercamelcase',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'uppercamelcase',
            ],
            [
                'before' => 'snake_case',
                'after' => 'snakecase',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'nonecasefoobar',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'nonecasefoobar',
            ],
        ],
        'UPPERCASE' => [
            [
                'before' => 'lowercase',
                'after' => 'LOWERCASE',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'UPPERCASE',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'LOWERCAMELCASE',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'UPPERCAMELCASE',
            ],
            [
                'before' => 'snake_case',
                'after' => 'SNAKECASE',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'NONECASEFOOBAR',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'NONECASEFOOBAR',
            ],
        ],
        'lowerCamelCase' => [
            [
                'before' => 'lowercase',
                'after' => 'lowercase',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'uppercase',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'lowerCamelCase',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'upperCamelCase',
            ],
            [
                'before' => 'snake_case',
                'after' => 'snakeCase',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'noneCaseFooBar',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'noneCaseFooBar',
            ],
        ],
        'UpperCamelCase' => [
            [
                'before' => 'lowercase',
                'after' => 'Lowercase',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'Uppercase',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'LowerCamelCase',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'UpperCamelCase',
            ],
            [
                'before' => 'snake_case',
                'after' => 'SnakeCase',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'NoneCaseFooBar',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'NoneCaseFooBar',
            ],
        ],
        'snake_case' => [
            [
                'before' => 'lowercase',
                'after' => 'lowercase',
            ],
            [
                'before' => 'UPPERCASE',
                'after' => 'uppercase',
            ],
            [
                'before' => 'lowerCamelCase',
                'after' => 'lower_camel_case',
            ],
            [
                'before' => 'UpperCamelCase',
                'after' => 'upper_camel_case',
            ],
            [
                'before' => 'snake_case',
                'after' => 'snake_case',
            ],
            [
                'before' => 'noneCase_fooBar',
                'after' => 'none_case_foo_bar',
            ],
            [
                'before' => 'NoneCase_fooBar',
                'after' => 'none_case_foo_bar',
            ],
        ],
    ];

    /**
     * @var \App\NameConverter\NameConverter
     */
    private $nameConverter;

    protected function setUp(): void
    {
        $this->nameConverter = new NameConverter(new ConverterManager());
    }

    public function testConvert()
    {
        foreach (self::TEST_CASES as $type => $cases) {
            foreach ($cases as $case) {
                $actual = $this->nameConverter->convert($case['before'], $type);
                $this->assertEquals(
                    $case['after'],
                    $actual,
                    sprintf(
                        'Converter type \'%s\' should return \'%s\' on string \'%s\', returns: \'%s\'',
                        $type,
                        $case['after'],
                        $case['before'],
                        $actual
                    )
                );
            }
        }
    }
}
