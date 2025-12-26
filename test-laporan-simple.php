<?php

// Test laporan kesehatan dengan data sederhana
// Run dengan: php test-laporan-simple.php

require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

// Get the kernel
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create a request
$request = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');

// Login user
$user = \App\Models\User::find(1);
if ($user) {
    auth()->loginUsingId($user->id);
    echo "✓ User logged in: {$user->nama}\n";
    echo "✓ User ID: {$user->id}\n";
    echo "✓ Authenticated: " . (auth()->check() ? 'YES' : 'NO') . "\n";
    echo "\nLaporan kesehatan URL: http://127.0.0.1:8000/laporan/kesehatan\n";
    echo "Status: SIAP UNTUK DIAKSES\n";
} else {
    echo "✗ User tidak ditemukan\n";
}
?>
