<?php

namespace App\Generator\Plugin;

use App\Generator\GeneratorBase;

class PhpGenerator extends GeneratorBase
{

    /**
     * {@inheritDoc}
     */
    public function generate(array $structure, string $namespace, array $configs): void
    {
        foreach ($structure as $objectEntity) {
            $values = [];
            $values['namespace'] = $namespace;
            $className = $this->nameConverter->convert(
                $objectEntity->getName(),
                $configs['classname_case']
            );
            $values['classname'] = $className;

            foreach ($objectEntity->getProperties() as $property) {
                if ($property->isObject()) {
                    if (isset($structure[$property->getObjectTypeName()])) {
                        $propertyClassName = $this->nameConverter->convert(
                            $property->getObjectTypeName(),
                            $configs['classname_case']
                        );

                        $type = str_replace('object', $propertyClassName, $property->getType());

                        if ($configs['prepend_namespaces']) {
                            $type = '\\' . $namespace . '\\' . $type;
                        }
                    } else {
                        $type = 'mixed';
                    }
                } else {
                    $type = $property->getType();
                }

                $values['properties'][] = [
                    'name' => $this->nameConverter->convert(
                        $property->getName(),
                        $configs['property_case'],
                    ),
                    'type' => $type,
                ];
            }

            $this->renderer->render(
                $configs['output_dir'] . '/' . $className . '.php',
                'class.html.twig',
                $values
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function getPluginId(): string
    {
        return 'php';
    }
}
