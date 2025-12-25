<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get user niki
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();
if (!$user) {
    echo "User tidak ditemukan\n";
    exit;
}

echo "User: " . $user->nama . " (ID: " . $user->id . ")\n";
echo "====================================\n\n";

// Get aktivitas data
$aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->latest('tanggal')
    ->get();

echo "Total data aktivitas: " . count($aktivitas) . "\n\n";

// Show all records
foreach ($aktivitas as $item) {
    echo "ID: " . $item->id . "\n";
    echo "  Tanggal: " . $item->tanggal . "\n";
    echo "  Berat Badan: " . $item->berat_badan . "\n";
    echo "  Tinggi Badan: " . $item->tinggi_badan . "\n";
    echo "  Jam Tidur: " . $item->jam_tidur . "\n";
    echo "  Olahraga: " . $item->olahraga . "\n";
    echo "---\n";
}

echo "\n====================================\n";
echo "Rata-rata Berat Badan: " . $aktivitas->avg('berat_badan') . " kg\n";
echo "Rata-rata Jam Tidur: " . $aktivitas->avg('jam_tidur') . " jam\n";
echo "Total Olahraga: " . $aktivitas->sum('olahraga') . " menit\n";
