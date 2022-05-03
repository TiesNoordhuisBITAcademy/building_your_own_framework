<?php

declare(strict_types = 1);

namespace BYOF\controllers;

use Twig\Environment as TwigEnvironment;

class BaseController
{
    protected $twig;

    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    protected function display(string $template, array $data = [])
    {
        $this->twig->display($template, $data);
    }
}