<?php
// Quick update untuk set password user yang ada

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Hash password 'password'
$hash = Hash::make('password');

// Update user pertama dengan hash password baru
$user = \App\Models\User::first();
if ($user) {
    $user->password_hash = $hash;
    $user->password = $hash;
    $user->save();
    
    echo "User updated successfully!\n";
    echo "Email: " . $user->email . "\n";
    echo "New password hash: " . $hash . "\n";
} else {
    echo "No user found!\n";
}
