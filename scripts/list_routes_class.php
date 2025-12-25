<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = $app['router']->getRoutes();

foreach ($routes as $route) {
    $uri = $route->uri();
    $controllerClass = null;
    try {
        $controllerClass = $route->getControllerClass();
    } catch (Exception $e) {
        $controllerClass = 'ERR:' . $e->getMessage();
    }
    $action = isset($route->getAction()['uses']) ? $route->getAction()['uses'] : null;
    echo "URI: $uri\n";
    echo "ControllerClass: " . ($controllerClass ?? 'NULL') . "\n";
    echo "Action: " . (is_string($action) ? $action : gettype($action)) . "\n";
    echo str_repeat('-', 40) . "\n";
}
