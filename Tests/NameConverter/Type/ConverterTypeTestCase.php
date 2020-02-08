<?php

namespace App\Tests\NameConverter\Type;

use App\Container\Container;
use App\NameConverter\ConverterTypeInterface;
use PHPUnit\Framework\TestCase;

abstract class ConverterTypeTestCase extends TestCase
{

    public function testCheck()
    {
        $converter = $this->getConverterInstance();

        foreach ($this->getSuccessCases() as $case) {
            $this->assertTrue(
                $converter->check($case),
                sprintf(
                    'Converter type %s check should return true on string %s',
                    $converter::getPluginId(),
                    $case
                )
            );
        }

        foreach ($this->getErrorCases() as $case) {
            $this->assertFalse(
                $converter->check($case),
                sprintf(
                    'Converter type %s check should return false on string %s',
                    $converter::getPluginId(),
                    $case
                )
            );
        }
    }

    protected function getConverterInstance(): ConverterTypeInterface
    {
        return Container::getInstance()
            ->get('converter.manager')
            ->getPluginInstance($this->getConverterId());
    }

    abstract protected function getConverterId(): string;

    abstract protected function getSuccessCases(): array;

    abstract protected function getErrorCases(): array;
}
