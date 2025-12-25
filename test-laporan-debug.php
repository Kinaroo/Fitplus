<?php

// Test laporan kesehatan view

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$user = \App\Models\User::find(1);
auth()->setUser($user);

// Simulate request dengan periode
$request = new \Illuminate\Http\Request();
$request->merge(['periode' => '30']);

// Call controller
$controller = new \App\Http\Controllers\LaporanController();
$response = $controller->kesehatan($request);

// Check what was returned
echo "=== LAPORAN KESEHATAN TEST ===\n";
echo "Response type: " . get_class($response) . "\n";

// If it's a view, get the view data
if ($response instanceof \Illuminate\View\View) {
    echo "View data keys: " . implode(', ', array_keys($response->getData())) . "\n";
    
    $data = $response->getData();
    echo "User: " . $data['user']->nama . "\n";
    echo "Stats keys: " . implode(', ', array_keys($data['stats'])) . "\n";
    echo "Rekomendasi count: " . count($data['rekomendasi']) . "\n";
    
    echo "\n✓ Laporan kesehatan sudah siap dirender!\n";
} else {
    echo "⚠ Response bukan view\n";
}

?>
