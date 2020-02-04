<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Renderer
{

    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader([realpath(__DIR__ . '/../templates')], __DIR__ . '/../templates');
        $this->twig = new Environment($loader);
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
        file_put_contents($fileName, $content);
    }
}
