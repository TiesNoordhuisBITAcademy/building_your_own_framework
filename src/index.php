<?php

declare(strict_types=1);

namespace BYOF;

require_once '../vendor/autoload.php';

use BYOF\services\ViewService;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

@list(, $controllerName, $methodName) = explode('/', $urlPath);

$controllerName = !empty($controllerName) ? ucfirst($controllerName) : 'Home';
$methodName = !empty($methodName) ? $methodName : 'index';
$methodName .= match ($_SERVER['REQUEST_METHOD']) {
    'POST' => 'Post',
    'PUT' => 'Put',
    'DELETE' => 'Delete',
    default => '',
};

header("X-Controller: $controllerName");
header("X-Method: $methodName");

$controllerClassPath = "BYOF\controllers\\{$controllerName}Controller";

$viewService = new ViewService();

if (
    !class_exists($controllerClassPath)
    || !method_exists($controllerClassPath, $methodName)
) {
    $viewService->display('@errors/404.html', statusCode: 404);
    exit();
}


$controller = new $controllerClassPath($viewService);
$controller->$methodName();
