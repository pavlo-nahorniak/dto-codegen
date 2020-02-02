<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\ConverterTypeInterface;
use App\NameConverter\Type\LowerCaseConverterType;

class LowerCaseConverterTypeTest extends TypeTestCase
{

    protected function getConverterInstance(): ConverterTypeInterface
    {
        return LowerCaseConverterType::getInstance();
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
