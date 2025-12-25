#!/usr/bin/env php
<?php
/**
 * Test Login Flow
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n========================================\n";
echo "🔐 Testing Login Flow\n";
echo "========================================\n\n";

$testLogins = [
    ['email' => 'test@example.com', 'password' => 'password'],
    ['email' => 'admin@fitplus.com', 'password' => 'admin123'],
    ['email' => 'dzacky@gmail.com', 'password' => 'dzacky123'],
];

foreach ($testLogins as $i => $login) {
    echo "Test " . ($i + 1) . ": {$login['email']}\n";
    
    $user = User::where('email', $login['email'])->first();
    
    if (!$user) {
        echo "  ✗ User NOT found\n\n";
        continue;
    }
    
    echo "  ✓ User found: {$user->nama}\n";
    
    $passwordValid = Hash::check($login['password'], $user->password);
    
    if ($passwordValid) {
        echo "  ✓ Password VALID\n";
        echo "  ✓ Login WILL SUCCEED\n";
    } else {
        echo "  ✗ Password INVALID\n";
        echo "  ✗ Login WILL FAIL\n";
    }
    
    echo "\n";
}

echo "========================================\n";
echo "Ready to login at: http://localhost:8000\n";
echo "========================================\n\n";
?>
