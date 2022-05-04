<?php

declare(strict_types=1);

namespace BYOF\services;

use Twig\Environment as TwigEnvironment;
use Twig\Error\Error as TwigError;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;

class ViewService
{
    private TwigFilesystemLoader $loader;
    private TwigEnvironment $environment;

    public function __construct()
    {
        try {
            $this->loader = new TwigFilesystemLoader('./views');
            $this->loader->addPath('./views/errors', 'errors');
            $this->environment = new TwigEnvironment($this->loader);
        } catch (TwigError $e) {
            $this->error("ViewService failed to initialize. {$e->getMessage()}");
        }
    }

    public function display(string $template, array $data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        try {
            $this->environment->display($template, $data);
        } catch (TwigError $e) {
            $this->error("ViewService failed to display template. {$e->getMessage()}");
        }
    }

    private function error(string $logMessage = "ViewService error"): void
    {
        error_log($logMessage);
        http_response_code(500);
        exit();
    }

    public function addPath(string $path, string $namespace): void
    {
        if (empty($this->loader->getPaths($namespace))) {
            $this->loader->addPath($path, $namespace);
        }
    }
}