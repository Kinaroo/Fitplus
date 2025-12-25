<?php

// load composer and app
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = $app['router']->getRoutes();

foreach ($routes as $route) {
    $uri = $route->uri();
    $action = $route->getActionName();
    $uses = $route->getAction();
    $usesString = isset($uses['uses']) ? (is_array($uses['uses']) ? implode('@',$uses['uses']) : $uses['uses']) : '';
    echo "URI: $uri\n";
    echo "ActionName: $action\n";
    echo "Uses: $usesString\n";
    echo str_repeat('-', 40) . "\n";
}
