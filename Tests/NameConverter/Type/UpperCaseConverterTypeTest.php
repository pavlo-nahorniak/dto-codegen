<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\Type\UpperCaseConverterType;

class UpperCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterId(): string
    {
        return UpperCaseConverterType::getPluginId();
    }

    protected function getSuccessCases(): array
    {
        return [
            'UPPERCASE',
        ];
    }

    protected function getErrorCases(): array
    {
        return [
            'lowercase',
            'lowerCamelCase',
            'UpperCamelCase',
            'snake_case',
            'noneCase_fooBar',
            'NoneCase_fooBar',
        ];
    }
}
