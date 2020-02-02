<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\ConverterTypeInterface;
use App\NameConverter\Type\UpperCamelCaseConverterType;

class UpperCamelCaseConverterTypeTest extends TypeTestCase
{

    protected function getConverterInstance(): ConverterTypeInterface
    {
        return UpperCamelCaseConverterType::getInstance();
    }

    protected function getSuccessCases(): array
    {
        return [
            'UpperCamelCase',
            'NoneCase_fooBar',
        ];
    }

    protected function getErrorCases(): array
    {
        return [
            'lowercase',
            'UPPERCASE',
            'lowerCamelCase',
            'snake_case',
            'noneCase_fooBar',
        ];
    }
}
