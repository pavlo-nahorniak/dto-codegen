<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\ConverterTypeInterface;
use App\NameConverter\Type\NoneCaseConverterType;

class NoneCaseConverterTypeTest extends ConverterTypeTestCase
{

    protected function getConverterInstance(): ConverterTypeInterface
    {
        return NoneCaseConverterType::getInstance();
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
