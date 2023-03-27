<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS);
define('APP_PATH', __DIR__ . DS . 'app' . DS);
define('CORE_PATH', BASE_PATH . '__core' . DS);
define('CONFIG_PATH', APP_PATH . 'config' . DS);
define('CONTROLLER_PATH', APP_PATH . 'controllers' . DS);
define('SERVICE_PATH', APP_PATH . 'services' . DS);
define('RESOURCE_PATH', BASE_PATH . 'resources' . DS);
define('PUBLIC_PATH', BASE_PATH . 'public' . DS);

require_once BASE_PATH . 'autoload.php';

if (isset($_GET['router'])) {
    $router = explode('/', $_GET['router']);
} else {
    $REQUEST_URI = trim($_SERVER['REQUEST_URI'], '/');
    $router = explode('/', $REQUEST_URI);
}

$index = [
    'controller' => 0,
    'action' => 1,
    'param' => 2
];

if ($router[0] === 'api') {
    Response::setApi();
    $index = [
        'controller' => 1,
        'action' => 2,
        'param' => 3
    ];
}

if (!isset($router[$index['controller']])) {
    Response::badRequest('Controller not exists (in path)!');
}

if (!isset($router[$index['action']])) {
    Response::badRequest('Action not exists (in path)!');
}

$controller = $router[$index['controller']];
$action = $router[$index['action']];
$parameter = [];

if (count($router) > 2) {
    $parameter = array_slice($router, $index['param']);
}

$prefixController = ucfirst(strtolower($controller));

$service = $prefixController . 'Service';
$servicePath = SERVICE_PATH . "$service.php";
if (file_exists($servicePath)) {
    require_once $servicePath;
}

$controller = $prefixController . 'Controller';
$controllerPrefixPath = CONTROLLER_PATH . (Response::isApi() ? "api" . DS : '');
$controllerPath = $controllerPrefixPath . "$controller.php";

if (!file_exists($controllerPath)) {
    Response::badRequest('Controller not exists (in source)!');
}

require_once $controllerPath;

$controllerInstance = new $controller;
$controllerInstance->{$action}(...$parameter);
