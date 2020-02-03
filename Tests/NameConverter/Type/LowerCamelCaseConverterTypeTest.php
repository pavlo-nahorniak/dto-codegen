<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\ConverterTypeInterface;
use App\NameConverter\Type\LowerCamelCaseConverterType;

class LowerCamelCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterInstance(): ConverterTypeInterface
    {
        return LowerCamelCaseConverterType::getInstance();
    }

    protected function getSuccessCases(): array
    {
        return [
            'lowerCamelCase',
            'noneCase_fooBar',
        ];
    }

    protected function getErrorCases(): array
    {
        return [
            'lowercase',
            'UPPERCASE',
            'UpperCamelCase',
            'snake_case',
            'NoneCase_fooBar',
        ];
    }
}
