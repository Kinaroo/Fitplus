<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate DashboardController::index() fully
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();
if (!$user) {
    echo "User tidak ditemukan\n";
    exit;
}

echo "=== TESTING DASHBOARD CONTROLLER ===\n\n";

// Get aktivitas data for weight statistics
$aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->latest('tanggal')
    ->limit(30)
    ->get();

// Get tidur data for sleep statistics (7 days)
$tidurData = \App\Models\TidurUser::where('user_id', $user->id)
    ->orderBy('tanggal', 'desc')
    ->limit(7)
    ->get();

// Calculate statistics
$rataBerat = $aktivitas->count() > 0 ? round($aktivitas->avg('berat_badan'), 1) : 0;

// Calculate rata-rata tidur from tidur_user table
$rataTidur = 0;
if ($tidurData->count() > 0) {
    $totalTidur = $tidurData->sum('durasi_jam');
    $rataTidur = round($totalTidur / $tidurData->count(), 1);
}

$totalOlahraga = $aktivitas->count() > 0 ? $aktivitas->sum('olahraga') : 0;

echo "Aktivitas Data:\n";
echo "  Count: " . $aktivitas->count() . "\n";
echo "  Rata-rata Berat: $rataBerat kg\n";
echo "  Total Olahraga: $totalOlahraga menit\n\n";

echo "Tidur Data:\n";
echo "  Count: " . $tidurData->count() . "\n";
echo "  Rata-rata Tidur: $rataTidur jam\n";
foreach ($tidurData as $t) {
    echo "    - " . $t->tanggal . ": " . $t->durasi_jam . " jam\n";
}

echo "\n=== DASHBOARD SUMMARY CARDS VALUES ===\n";
echo "Rata-rata Berat: $rataBerat kg\n";
echo "Rata-rata Tidur: $rataTidur jam\n";
echo "Total Olahraga: $totalOlahraga menit\n";
