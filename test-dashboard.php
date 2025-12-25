<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate DashboardController::index()
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();
if (!$user) {
    echo "User tidak ditemukan\n";
    exit;
}

echo "User: " . $user->nama . " (ID: " . $user->id . ")\n";
echo "====================================\n\n";

// Get aktivitas data - sama seperti di controller
$aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->latest('tanggal')
    ->limit(30)
    ->get();

echo "Total records retrieved: " . count($aktivitas) . "\n\n";

// Calculate statistics - sama seperti di controller
$rataBerat = $aktivitas->count() > 0 ? round($aktivitas->avg('berat_badan'), 1) : 0;
$rataTidur = $aktivitas->count() > 0 ? round($aktivitas->avg('jam_tidur'), 1) : 0;
$totalOlahraga = $aktivitas->count() > 0 ? $aktivitas->sum('olahraga') : 0;

echo "Hasil kalkulasi:\n";
echo "  Rata-rata Berat: $rataBerat kg\n";
echo "  Rata-rata Tidur: $rataTidur jam\n";
echo "  Total Olahraga: $totalOlahraga menit\n";
echo "  Count: " . $aktivitas->count() . " data\n";
