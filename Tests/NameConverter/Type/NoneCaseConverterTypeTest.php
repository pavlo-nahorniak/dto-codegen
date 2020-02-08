<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\Type\NoneCaseConverterType;

class NoneCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterId(): string
    {
        return NoneCaseConverterType::getPluginId();
    }

    protected function getSuccessCases(): array
    {
        return [
            'lowercase',
            'UPPERCASE',
            'lowerCamelCase',
            'UpperCamelCase',
            'snake_case',
            'noneCase_fooBar',
            'NoneCase_fooBar',
        ];
    }

    protected function getErrorCases(): array
    {
        return [];
    }
}
