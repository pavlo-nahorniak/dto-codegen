<?php

namespace App\Tests\NameConverter\Type;

use App\NameConverter\ConverterTypeInterface;
use PHPUnit\Framework\TestCase;

abstract class TypeTestCase extends TestCase
{

    public function testCheck()
    {
        $converter = $this->getConverterInstance();

        foreach ($this->getSuccessCases() as $case) {
            $this->assertTrue(
                $converter->check($case),
                sprintf(
                    'Converter type %s check should return true on string %s',
                    $converter::getType(),
                    $case
                )
            );
        }

        foreach ($this->getErrorCases() as $case) {
            $this->assertFalse(
                $converter->check($case),
                sprintf(
                    'Converter type %s check should return false on string %s',
                    $converter::getType(),
                    $case
                )
            );
        }
    }

    abstract protected function getConverterInstance(): ConverterTypeInterface;

    abstract protected function getSuccessCases(): array;

    abstract protected function getErrorCases(): array;
}
