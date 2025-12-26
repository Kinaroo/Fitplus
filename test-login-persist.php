<?php
// Test login persistence

require __DIR__ . '/vendor/autopath.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

echo "=== LOGIN PERSISTENCE TEST ===\n\n";

// Simulasi user login
$user = \App\Models\User::find(1);
if (!$user) {
    echo "❌ User 1 tidak ditemukan\n";
    exit(1);
}

echo "✓ User ditemukan: {$user->nama}\n\n";

// Create dan handle login request
echo "1. Testing login request handling...\n";
$loginRequest = \Illuminate\Http\Request::create('/login', 'POST', [
    '_token' => csrf_token(),
    'email' => $user->email,
    'password' => 'password', // We'll use a test password
]);
$loginRequest->session()->start();

echo "   Session ID: " . $loginRequest->session()->getId() . "\n";
echo "   Session started: " . ($loginRequest->session()->isStarted() ? 'Yes' : 'No') . "\n\n";

// Test direct auth
echo "2. Testing auth()->loginUsingId()...\n";
$testRequest = \Illuminate\Http\Request::create('/test', 'GET');
$testRequest->setSession($loginRequest->session());
$testRequest->setUserResolver(function() { 
    return auth()->user(); 
});

// Authenticate manually
auth()->loginUsingId($user->id);
echo "   Authenticated: " . (auth()->check() ? 'Yes ✓' : 'No ✗') . "\n";
echo "   Auth user: " . (auth()->user() ? auth()->user()->nama : 'None') . "\n";

// Now test if laporan can be accessed
echo "\n3. Testing laporan kesehatan access...\n";
$laporanRequest = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');
$laporanRequest->setUserResolver(function() { 
    return auth()->user(); 
});

$authCheck = auth()->check();
echo "   Auth check: " . ($authCheck ? 'Authenticated ✓' : 'Not authenticated ✗') . "\n";

if ($authCheck) {
    $controller = new \App\Http\Controllers\LaporanController();
    try {
        $response = $controller->kesehatan($laporanRequest);
        if ($response instanceof \Illuminate\View\View) {
            echo "   ✓ Laporan view returned successfully\n";
        } else {
            echo "   Response type: " . get_class($response) . "\n";
        }
    } catch (\Exception $e) {
        echo "   ✗ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ✗ Cannot access laporan - user not authenticated\n";
}

echo "\n4. Testing session persistence...\n";
echo "   Session cookies: " . json_encode($loginRequest->cookies->all()) . "\n";
?>
