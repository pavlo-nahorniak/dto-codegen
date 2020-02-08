<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\Type\LowerCaseConverterType;

class LowerCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterId(): string
    {
        return LowerCaseConverterType::getPluginId();
    }

    protected function getSuccessCases(): array
    {
        return [
            'lowercase',
        ];
    }

    protected function getErrorCases(): array
    {
        return [
            'UPPERCASE',
            'lowerCamelCase',
            'UpperCamelCase',
            'snake_case',
            'noneCase_fooBar',
            'NoneCase_fooBar',
        ];
    }
}
