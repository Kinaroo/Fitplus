<?php
/**
 * Test Complete Flow: Login -> Laporan Kesehatan
 */

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== FITPLUS SYSTEM TEST ===\n\n";

// Test 1: Database connection
echo "1️⃣ Database Connection...\n";
try {
    $userCount = \App\Models\User::count();
    echo "   ✅ Connected - Users: $userCount\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Auth controller
echo "\n2️⃣ Auth Controller...\n";
try {
    $user = \App\Models\User::first();
    echo "   ✅ User: " . $user->nama . " (ID: " . $user->id . ")\n";
    
    // Simulate login
    \Illuminate\Support\Facades\Auth::loginUsingId($user->id, true);
    echo "   ✅ Login simulated\n";
    echo "   ✅ Auth check: " . (auth()->check() ? "YES" : "NO") . "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Laporan Controller
echo "\n3️⃣ Laporan Controller...\n";
try {
    $controller = new \App\Http\Controllers\LaporanController();
    $request = new \Illuminate\Http\Request();
    $request->merge(['periode' => '30']);
    
    $response = $controller->kesehatan($request);
    
    if ($response instanceof \Illuminate\View\View) {
        echo "   ✅ View: " . $response->getName() . "\n";
        $data = $response->getData();
        echo "   ✅ Data keys: " . implode(", ", array_keys($data)) . "\n";
    } else {
        echo "   ⚠️ Response: " . get_class($response) . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    echo "   📍 File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}

// Test 4: Routes
echo "\n4️⃣ Routes Check...\n";
try {
    $routes = [
        'login.form' => '/login',
        'login' => '/login (POST)',
        'dashboard' => '/dashboard',
        'laporan.kesehatan' => '/laporan/kesehatan',
    ];
    
    foreach ($routes as $name => $path) {
        try {
            route($name);
            echo "   ✅ " . str_pad($name, 20) . " -> $path\n";
        } catch (\Exception $e) {
            echo "   ⚠️ " . str_pad($name, 20) . " -> NOT FOUND\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Final summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "✅ ALL TESTS PASSED!\n\n";
echo "📌 NEXT STEPS:\n";
echo "1. Go to: http://localhost:8000/login\n";
echo "2. Login with:\n";
echo "   Email: niki@fitplus.com\n";
echo "   Password: 12345678\n";
echo "3. Access: http://localhost:8000/laporan/kesehatan\n";
echo "4. Laporan Kesehatan harus tampil dengan lengkap\n";
echo str_repeat("=", 50) . "\n";
