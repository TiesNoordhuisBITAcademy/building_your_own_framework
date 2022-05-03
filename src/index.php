<?php

declare(strict_types = 1);

namespace BYOF;

use BYOF\services\ViewService;

require_once '../vendor/autoload.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

@list(, $controllerName, $methodName) = explode('/', $urlPath);

$controllerName = !empty($controllerName) ? ucfirst($controllerName) : 'Home';
$methodName = !empty($methodName) ? $methodName : 'index';

header("X-Controller: $controllerName");
header("X-Method: $methodName");

$controllerClassPath = "BYOF\controllers\\{$controllerName}Controller";

$viewService = new ViewService();

if (
    !class_exists($controllerClassPath)
    || !method_exists($controllerClassPath, $methodName)
) {
    $viewService->display('@errors/404.html', statusCode: 404);
}

$controller = new $controllerClassPath($viewService);
$controller->$methodName();
