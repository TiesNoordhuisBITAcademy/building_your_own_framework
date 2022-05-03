<?php

namespace BYOF;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

@list(, $controllerName, $methodName) = explode('/', $urlPath);

$controllerName = !empty($controllerName) ? ucfirst($controllerName) : 'Home';
$methodName = !empty($methodName) ? $methodName : 'index';

header("X-Controller: $controllerName");
header("X-Method: $methodName");

$controllerClassPath = "BYOF\controllers\\{$controllerName}Controller";

if (
    !class_exists($controllerClassPath)
    || !method_exists($controllerClassPath, $methodName)
) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

$twigLoader = new FilesystemLoader('./views');
$twig = new Environment($twigLoader);

$controller = new $controllerClassPath($twig);
$controller->$methodName();
