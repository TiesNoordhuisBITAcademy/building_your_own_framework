<?php

namespace BYOF;

require_once '../vendor/autoload.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

@list(, $controller, $method) = explode('/', $urlPath);

$controller = !empty($controller) ? ucfirst($controller) : 'Home';
$method = !empty($method) ? $method : 'index';

header("X-Controller: $controller");
header("X-Method: $method");

if (!file_exists("controllers/{$controller}Controller.php")) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

$controller = new ("\BYOF\controllers\\{$controller}Controller")("");

if (!method_exists($controller, $method)) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

$controller->$method();
