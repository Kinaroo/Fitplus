<?php

require __DIR__ . '/vendor/autoload.php';

// Create app instance
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate request
$request = Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');

// Set session
session_start();
$_SESSION['PHPSESSID'] = 'test_session_' . time();

// Manually login test user
auth()->loginUsingId(7);

try {
    $response = $kernel->handle($request);
    
    // Get response content
    if ($response instanceof \Illuminate\Http\Response) {
        echo "Status: " . $response->status() . "\n";
        echo "Content Type: " . $response->headers->get('Content-Type') . "\n";
        echo "===== CONTENT START =====\n";
        echo substr($response->content(), 0, 500) . "\n";
        echo "===== CONTENT END =====\n";
    } else {
        echo "Response Type: " . get_class($response) . "\n";
        echo "Response Content (first 500 chars):\n";
        echo substr($response->getContent(), 0, 500) . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack: \n" . $e->getTraceAsString() . "\n";
}
?>
