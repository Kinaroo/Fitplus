#!/usr/bin/env php
<?php
/**
 * Check Database Users
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n========================================\n";
echo "🔍 Checking Users in Database\n";
echo "========================================\n\n";

// Check all users
$users = DB::table('users')->get();
echo "Total users in database: " . count($users) . "\n\n";

foreach ($users as $user) {
    echo "─────────────────────────────────────\n";
    echo "ID: {$user->id}\n";
    echo "Nama: {$user->nama}\n";
    echo "Email: {$user->email}\n";
    echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";
    echo "─────────────────────────────────────\n";
}

echo "\n✓ Test Login dengan test@example.com\n";
$testUser = User::where('email', 'test@example.com')->first();
if ($testUser) {
    echo "  ✓ User found\n";
    $passwordCheck = Hash::check('password', $testUser->password);
    echo "  Password check (password): " . ($passwordCheck ? "✓ VALID" : "✗ INVALID") . "\n";
} else {
    echo "  ✗ User NOT found\n";
}

echo "\n========================================\n";
?>
