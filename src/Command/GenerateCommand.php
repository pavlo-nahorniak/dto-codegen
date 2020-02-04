<?php

namespace App\Command;

use App\GeneratorManager;
use App\ParserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class GenerateFromJSON.
 *
 * @package App\Command
 */
class GenerateCommand extends Command
{

    /**
     * {@inheritDoc}
     */
    protected static $defaultName = 'generate';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->addOption(
            'config-file',
            null,
            InputOption::VALUE_REQUIRED,
            'Yaml formatted config file.',
            'dto-codegen.yml'
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getOption('config-file');

        if (!empty($configFile)) {
            $config = $this->getConfig($configFile);
        } else {
            throw new InvalidOptionException('Config file option should not be empty!');
        }

        $parserManager = new ParserManager();
        if (!in_array($config['parser'], $parserManager->getAvailablePlugins())) {
            throw new InvalidOptionException(
                sprintf(
                    'There is no parser %s! Available list of parsers: %s',
                    $config['parser'],
                    implode(', ', $parserManager->getAvailablePlugins())
                )
            );
        }

        if (isset($config['fromFile'])) {
            $data = file_get_contents($config['fromFile']);
        } else {
            $data = $config['fromString'];
        }

        if (empty($data)) {
            throw new InvalidOptionException('Unable to read the data.');
        }

        $parser = $parserManager->getPluginInstance($config['parser']);
        $structure = $parser->parse($data);

        $generatorManager = new GeneratorManager();
        /** @var \App\GeneratorInterface $generator */
        $generator = $generatorManager->getPluginInstance($config['generator']);

        $generatorConfigs = $config;
        unset($generatorConfigs['fromFile']);
        unset($generatorConfigs['fromString']);
        unset($generatorConfigs['parser']);
        unset($generatorConfigs['generator']);
        unset($generatorConfigs['namespace']);

        $generator->generate(
            $structure,
            trim($config['namespace'], '\\'),
            $generatorConfigs
        );

        return 0;
    }

    private function getConfig(string $configFile): array
    {
        $tmpDir = getcwd();

        if (strpos($configFile, '/') !== 0) {
            $configFile = $tmpDir . '/' . $configFile;
        }

        if (!realpath($configFile)) {
            throw new InvalidOptionException(sprintf('File %s does not exist.', $configFile));
        }

        $config = Yaml::parseFile(realpath($configFile));

        if (!empty($config['fromFile']) && !empty($config['fromString'])) {
            throw new InvalidOptionException(
                'Either `fromFile` or `fromString` should be used at same time, not both!'
            );
        }

        if (empty($config['fromFile']) && empty($config['fromString'])) {
            throw new InvalidOptionException('Either `fromFile` or `fromString` should not be empty!');
        }

        if (empty($config['parser'])) {
            throw new InvalidOptionException('Parser should not be empty!');
        }

        $config['classname_case'] = $config['classname_case'] ?? 'UpperCamelCase';
        $config['property_case'] = $config['property_case'] ?? 'lowerCamelCase';
        $config['generator'] = $config['generator'] ?? 'php';
        $config['prepend_namespaces'] = $config['prepend_namespaces'] ?? false;

        return $config;
    }
}
