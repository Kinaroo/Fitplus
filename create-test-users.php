#!/usr/bin/env php
<?php
/**
 * Create Test Users with Known Passwords
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n========================================\n";
echo "➕ Creating Test Users\n";
echo "========================================\n\n";

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Delete and recreate
DB::table('users')->truncate();
DB::table('aktivitas_user')->truncate();
DB::table('tidur_user')->truncate();
DB::table('makanan_user')->truncate();

// Re-enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1');

echo "✓ Cleared old data\n\n";

// Create test user 1
$user1 = User::create([
    'nama' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password'),
    'jenis_kelamin' => 'L',
    'tanggal_lahir' => '1990-01-01',
    'tinggi' => 170,
    'berat' => 70,
    'umur' => 35,
    'tingkat_aktivitas' => 1.55,
]);

echo "✓ User 1 created:\n";
echo "  Email: test@example.com\n";
echo "  Password: password\n\n";

// Create test user 2
$user2 = User::create([
    'nama' => 'Admin FitPlus',
    'email' => 'admin@fitplus.com',
    'password' => Hash::make('admin123'),
    'jenis_kelamin' => 'P',
    'tanggal_lahir' => '1995-05-15',
    'tinggi' => 165,
    'berat' => 60,
    'umur' => 30,
    'tingkat_aktivitas' => 1.50,
]);

echo "✓ User 2 created:\n";
echo "  Email: admin@fitplus.com\n";
echo "  Password: admin123\n\n";

// Create test user 3 - dzacky
$user3 = User::create([
    'nama' => 'Dzacky Aulia',
    'email' => 'dzacky@gmail.com',
    'password' => Hash::make('dzacky123'),
    'jenis_kelamin' => 'L',
    'tanggal_lahir' => '2000-05-20',
    'tinggi' => 172,
    'berat' => 72,
    'umur' => 25,
    'tingkat_aktivitas' => 1.55,
]);

echo "✓ User 3 created:\n";
echo "  Email: dzacky@gmail.com\n";
echo "  Password: dzacky123\n\n";

echo "========================================\n";
echo "✅ All test users created successfully!\n";
echo "========================================\n\n";

echo "Login credentials:\n\n";
echo "1. Test Account (recommended for demo):\n";
echo "   Email: test@example.com\n";
echo "   Password: password\n\n";

echo "2. Admin Account:\n";
echo "   Email: admin@fitplus.com\n";
echo "   Password: admin123\n\n";

echo "3. Dzacky Account:\n";
echo "   Email: dzacky@gmail.com\n";
echo "   Password: dzacky123\n\n";

echo "Now you can login at: http://localhost:8000/login\n\n";
?>
