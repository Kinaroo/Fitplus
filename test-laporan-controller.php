<?php
/**
 * Test Laporan Kesehatan dengan proper session handling
 */

// Start Laravel
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG LAPORAN KESEHATAN ===\n\n";

// Test 1: Check if user exists
$user = \App\Models\User::first();
if (!$user) {
    echo "❌ ERROR: No users in database\n";
    exit(1);
}
echo "✅ User exists: " . $user->nama . " (ID: " . $user->id . ")\n";

// Test 2: Manually authenticate
\Illuminate\Support\Facades\Auth::loginUsingId($user->id);
echo "✅ Auth set: " . (auth()->check() ? "YES" : "NO") . "\n";
echo "✅ User retrieved: " . auth()->user()->nama . "\n";

// Test 3: Try to call controller method
try {
    $controller = new \App\Http\Controllers\LaporanController();
    
    // Create fake request
    $request = new \Illuminate\Http\Request();
    $request->merge(['periode' => '30']);
    
    // Call kesehatan method
    $response = $controller->kesehatan($request);
    
    // Check if it's a view
    if ($response instanceof \Illuminate\View\View) {
        echo "✅ Controller returned view: " . $response->getName() . "\n";
        echo "✅ View data keys: " . implode(", ", array_keys($response->getData())) . "\n";
        echo "\n✅ ALL CHECKS PASSED!\n";
        echo "\n📌 Laporan Kesehatan should now be accessible at:\n";
        echo "   http://localhost:8000/laporan/kesehatan\n\n";
        echo "📌 Make sure to:\n";
        echo "   1. Login first\n";
        echo "   2. Clear browser cache (Ctrl+Shift+Delete)\n";
        echo "   3. Refresh page (Ctrl+F5)\n";
    } else {
        echo "⚠️ Controller returned: " . get_class($response) . "\n";
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            echo "   Redirect to: " . $response->getTargetUrl() . "\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
