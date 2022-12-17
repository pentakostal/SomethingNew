<?php

use App\Controllers\BuyStockController;
use App\Controllers\HomeController;
use App\Controllers\LogInController;
use App\Controllers\PersonalCabinetController;
use App\Controllers\RegisterController;
use App\Controllers\StockController;
use App\Redirect;

session_start();

require_once "vendor/autoload.php";

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [HomeController::class, 'index']);
    $route->addRoute('GET', '/register', [RegisterController::class, 'showRegistrationForm']);
    $route->addRoute('POST', '/registration', [RegisterController::class, 'storeRegistrationForm']);
    $route->addRoute('GET', '/logIn', [LogInController::class, 'showLogInForm']);
    $route->addRoute('POST', '/logInSystem', [LogInController::class, 'logToSystem']);
    $route->addRoute('GET', '/user', [StockController::class, 'index']);
    $route->addRoute('GET', '/search', [StockController::class, 'search']);
    $route->addRoute('GET', '/logOut', [LogInController::class, 'logOut']);
    $route->addRoute('GET', '/personalCabinet', [PersonalCabinetController::class, 'getPersonalCabinet']);
    $route->addRoute('POST', '/personalCabinet', [PersonalCabinetController::class, 'addMoney']);
    $route->addRoute('POST', '/user', [BuyStockController::class, 'buyStock']);
});

$loader = new \Twig\Loader\FilesystemLoader('view');
$twig = new \Twig\Environment($loader);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}($vars);

        if ($response instanceof \App\Template) {
            echo $twig->render($response->getPath(), $response->getParams());
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getUrl());
        }

        break;
}