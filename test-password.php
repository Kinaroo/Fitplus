<?php

// Test script untuk verifikasi password hashing dan login
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test 1: Hash password baru
$password = 'password';
$newHash = Hash::make($password);

echo "=== TEST PASSWORD HASHING ===\n\n";
echo "1. Testing new hash generation:\n";
echo "   Original: " . $password . "\n";
echo "   Hash: " . $newHash . "\n";
echo "   Check result: " . (Hash::check($password, $newHash) ? 'PASS ✓' : 'FAIL ✗') . "\n\n";

// Test 2: Check existing user
echo "2. Testing existing user:\n";
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();

if ($user) {
    echo "   Email: " . $user->email . "\n";
    echo "   Name: " . $user->nama . "\n";
    echo "   Hash: " . substr($user->password_hash, 0, 20) . "...\n";
    echo "   Check 'password': " . (Hash::check($password, $user->password_hash) ? 'PASS ✓' : 'FAIL ✗') . "\n";
    
    // Test 3: Update password to 'password' if needed
    if (!Hash::check($password, $user->password_hash)) {
        echo "\n   Updating password to 'password'...\n";
        $user->password_hash = Hash::make($password);
        $user->save();
        echo "   Updated! New hash: " . substr($user->password_hash, 0, 20) . "...\n";
        echo "   Verify check: " . (Hash::check($password, $user->password_hash) ? 'PASS ✓' : 'FAIL ✗') . "\n";
    }
} else {
    echo "   No user found with email najeroo@gmail.com\n";
}

echo "\n=== END TEST ===\n";

