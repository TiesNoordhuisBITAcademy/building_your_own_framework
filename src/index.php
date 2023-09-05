<?php

declare(strict_types=1);

namespace BYOF;

require_once '../vendor/autoload.php';

use BYOF\services\ViewService;
use BYOF\exceptions\FrameworkException;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

@[, $controllerName, $methodName, $arguments] = explode('/', $urlPath, 4);

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
    $viewService->display('404', statusCode: 404, namespace: 'error');
    exit();
}

$controller = new $controllerClassPath($viewService);
try {
    if (count($methodParams = getMethodParams($controllerClassPath, $methodName)) > 0) {
        $controller->$methodName(...mapArgumentsToParams($arguments, $methodParams));
    } else {
        $controller->$methodName();
    }
} catch (FrameworkException $exception) {
    $viewService->displayException($exception);
} catch (\Throwable $th) {
    $viewService->error($th->getMessage());
}
