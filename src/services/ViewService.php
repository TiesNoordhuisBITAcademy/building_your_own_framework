<?php

declare(strict_types=1);

namespace BYOF\services;

use BYOF\exceptions\FrameworkException;
use BYOF\exceptions\RouteException;
use Twig\Environment as TwigEnvironment;
use Twig\Error\Error as TwigError;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;

class ViewService
{
    private const VIEWS_PATH = './views';

    private TwigFilesystemLoader $loader;
    private TwigEnvironment $environment;
    private string $defaultNamespace = '__main__';

    public function __construct()
    {
        try {
            $this->loader = new TwigFilesystemLoader(self::VIEWS_PATH);
            $this->environment = new TwigEnvironment($this->loader);
            $this->addPath('error');
        } catch (TwigError $e) {
            $this->error("ViewService failed to initialize. {$e->getMessage()}");
        }
    }

    public function setDefaultPath(string $namespace): void
    {
        $this->addPath($namespace);
        $this->defaultNamespace = $namespace;
    }

    public function display(
        string $template,
        array $data = [],
        int $statusCode = 200,
        string $namespace = null
    ): void {
        http_response_code($statusCode);
        $namespace ??= $this->defaultNamespace;
        $template .= '.html';
        try {
            $this->environment->display("@$namespace/$template", $data);
        } catch (TwigError $e) {
            $this->error("ViewService failed to display template. {$e->getMessage()}");
        }
    }

    public function displayException(FrameworkException $exception): void
    {
        $data = [
            'message' => $exception->getMessage(),
            'source' => $exception->source,
        ];
        if ($exception instanceof RouteException) {
            $data['type'] = 'routeException';
            $data['originalRoute'] = $exception->originalRoute;
            $data['expectedRoute'] = $exception->expectedRoute;
        }
        try {
            $this->display(
                template: "frameworkException",
                data: $data,
                statusCode: 500,
                namespace: 'error'
            );
        } catch (TwigError $e) {
            $this->error("ViewService failed to display exception template. {$e->getMessage()}");
        }
    }

    public function error(string $logMessage = "ViewService error"): void
    {
        error_log($logMessage);
        http_response_code(500);
        exit();
    }

    private function addPath(string $namespace): void
    {
        if (!empty($this->loader->getPaths($namespace))) {
            throw new FrameworkException("$namespace path already exists", 'viewService');
        }

        $path = self::VIEWS_PATH . "/$namespace";
        if (!is_dir($path)) {
            throw new FrameworkException("$path directory for templates does not exist", "viewService");
        }

        $this->loader->addPath($path, $namespace);
    }
}
