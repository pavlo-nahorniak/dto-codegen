<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\Type\SnakeCaseConverterType;

class SnakeCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterId(): string
    {
        return SnakeCaseConverterType::getPluginId();
    }

    protected function getSuccessCases(): array
    {
        return [
            'snake_case',
            'noneCase_fooBar',
            'NoneCase_fooBar',
        ];
    }

    protected function getErrorCases(): array
    {
        return [
            'lowercase',
            'UPPERCASE',
            'lowerCamelCase',
            'UpperCamelCase',
        ];
    }
}
