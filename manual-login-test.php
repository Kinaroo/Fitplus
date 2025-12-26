<?php

// Manual login test script
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== MANUAL LOGIN TEST ===\n\n";

// Try to login
$email = 'najeroo@gmail.com';
$password = 'password';

echo "Attempting to login...\n";
echo "Email: " . $email . "\n";
echo "Password: " . $password . "\n\n";

$user = User::where('email', $email)->first();

if (!$user) {
    echo "Result: FAIL - User not found\n";
    echo "\nAvailable users:\n";
    User::all()->each(function($u) {
        echo "  - " . $u->email . " (" . $u->nama . ")\n";
    });
} else {
    echo "User found: " . $user->nama . "\n";
    
    $passwordMatch = Hash::check($password, $user->password_hash);
    echo "Password match: " . ($passwordMatch ? 'YES ✓' : 'NO ✗') . "\n";
    
    if ($passwordMatch) {
        echo "\nResult: LOGIN SUCCESS!\n";
        echo "User ID: " . $user->id . "\n";
    } else {
        echo "\nResult: PASSWORD MISMATCH\n";
        echo "Stored hash: " . substr($user->password_hash, 0, 30) . "...\n";
        
        // Try to fix it
        echo "\nAttempting to fix password...\n";
        $user->password_hash = Hash::make($password);
        $user->save();
        
        echo "Password updated!\n";
        $test = Hash::check($password, $user->password_hash);
        echo "Verify check: " . ($test ? 'PASS ✓' : 'FAIL ✗') . "\n";
    }
}

echo "\n=== END TEST ===\n";
