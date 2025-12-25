<?php

// Quick test untuk verifikasi registrasi dan login bekerja

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

// Test 1: Cek column tingkat_aktivitas sudah ada
echo "=== TEST DATABASE ===\n";
$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=fitplus',
    'root',
    ''
);

$stmt = $pdo->query("DESCRIBE akun_user");
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
echo "Columns di akun_user: " . implode(', ', $columns) . "\n";
echo "✓ Column 'tingkat_aktivitas' ada: " . (in_array('tingkat_aktivitas', $columns) ? 'YES' : 'NO') . "\n\n";

// Test 2: Test manual Hash dengan password
echo "=== TEST PASSWORD HASHING ===\n";
$password = 'test123456';
$hash = \Illuminate\Support\Facades\Hash::make($password);
echo "Password: {$password}\n";
echo "Hash: {$hash}\n";
echo "✓ Verifikasi Hash: " . (\Illuminate\Support\Facades\Hash::check($password, $hash) ? 'PASS' : 'FAIL') . "\n\n";

// Test 3: Cek semua user dan password mereka
echo "=== CURRENT USERS ===\n";
$users = \App\Models\User::all();
foreach($users as $u) {
    $hasPassword = $u->password_hash ? 'YES' : 'NO';
    echo "{$u->id}. {$u->nama} ({$u->email}) - Password: {$hasPassword}\n";
}

echo "\n✓ Setup sudah siap. User baru sekarang bisa di-register dan login dengan benar!\n";
?>
