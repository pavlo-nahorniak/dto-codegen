<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\Type\UpperCamelCaseConverterType;

class UpperCamelCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterId(): string
    {
        return UpperCamelCaseConverterType::getPluginId();
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
