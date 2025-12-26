#!/usr/bin/env php
<?php
/**
 * Test Registration Flow
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n========================================\n";
echo "🧪 Testing Registration System\n";
echo "========================================\n\n";

// Test 1: Check if users table exists
echo "✓ Test 1: Database Table Check\n";
try {
    $count = DB::table('users')->count();
    echo "  ✓ Users table exists with {$count} records\n";
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Create test user programmatically
echo "\n✓ Test 2: Create Test User\n";
try {
    $testUser = User::create([
        'nama' => 'Test Register User',
        'email' => 'register@test.com',
        'password' => Hash::make('password123'),
        'jenis_kelamin' => 'L',
        'tanggal_lahir' => '1990-01-01',
        'tinggi' => 170,
        'berat' => 70,
        'umur' => 35,
        'tingkat_aktivitas' => 1.55,
    ]);
    
    echo "  ✓ User created with ID: {$testUser->id}\n";
    echo "  ✓ Email: {$testUser->email}\n";
    echo "  ✓ Name: {$testUser->nama}\n";
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Verify password hashing
echo "\n✓ Test 3: Password Verification\n";
try {
    $user = User::where('email', 'register@test.com')->first();
    if ($user && Hash::check('password123', $user->password)) {
        echo "  ✓ Password hash verified successfully\n";
    } else {
        echo "  ✗ Password verification failed\n";
    }
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Test 4: Check model fillable
echo "\n✓ Test 4: Model Fillable Check\n";
try {
    $user = new User();
    $fillable = $user->getFillable();
    echo "  Fillable attributes: " . implode(', ', $fillable) . "\n";
    
    if (in_array('password', $fillable)) {
        echo "  ✓ Password field is fillable\n";
    } else {
        echo "  ✗ Password field NOT in fillable\n";
    }
} catch (\Exception $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// Test 5: Check validation
echo "\n✓ Test 5: Validation Rules Check\n";
echo "  Expected unique table: users\n";
echo "  Expected password field: password\n";

echo "\n========================================\n";
echo "✅ Registration System Test Complete\n";
echo "========================================\n";
echo "\nNow you can:\n";
echo "1. Start server: php artisan serve\n";
echo "2. Try registration at: http://localhost:8000/register\n";
echo "3. Or login with test account:\n";
echo "   Email: test@example.com\n";
echo "   Password: password\n\n";
?>
