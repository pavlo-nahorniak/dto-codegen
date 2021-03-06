<?php

namespace App;

use Twig\Environment;

class Renderer
{

    public const TWIG_DEFAULT_TEMPLATES = __DIR__ . '/../templates';

    public const TWIG_ROOT_PATH = __DIR__ . '/../templates';

    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var \App\FileSystem
     */
    private $fileSystem;

    public function __construct(Environment $environment, FileSystem $fileSystem)
    {
        $this->twig = $environment;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Renders and writes output to the file.
     *
     * @param string $fileName
     * @param string $template
     * @param array|null $vars
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $fileName, string $template, ?array $vars)
    {
        $content = $this->twig->render($template, $vars);
        $this->fileSystem->saveFile($fileName, $content);
    }
}
