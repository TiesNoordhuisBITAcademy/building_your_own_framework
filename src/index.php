<?php

declare(strict_types=1);

namespace BYOF;

require_once '../vendor/autoload.php';

use BYOF\controllers\BaseController;
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

$controllerClassExists = class_exists($controllerClassPath);
$controllerExtendsBase = is_subclass_of($controllerClassPath, BaseController::class, true);

header('X-Controller-Check: ' . "exists: $controllerClassExists; extends_base: $controllerExtendsBase;");

if (!$controllerClassExists || !$controllerExtendsBase) {
    $viewService->display('404', statusCode: 404, namespace: 'error');
    exit();
}
    
$controller = new $controllerClassPath($viewService);

$methodIsCallable = is_callable([$controller, $methodName]);
$methodExists = method_exists($controller, $methodName);
$methodIsMagic = str_starts_with($methodName, '__');

header('X-Method-Check: ' . "is_callable: $methodIsCallable; exists: $methodExists; magic: $methodIsMagic");

if (!$methodIsCallable || !$methodExists || $methodIsMagic ) {
    $viewService->display('404', statusCode: 404, namespace: 'error');
    exit();
}

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
