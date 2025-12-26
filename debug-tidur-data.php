<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'pajril@gmail')->first();
if (!$user) {
    echo "User tidak ditemukan, coba user 1...\n";
    $user = \App\Models\User::find(1);
}
if (!$user) {
    echo "User tidak ditemukan\n";
    exit;
}

echo "=== CEK DATA TIDUR TERBARU ===\n\n";

// Get all tidur data
$allTidur = \App\Models\TidurUser::where('user_id', $user->id)
    ->orderBy('tanggal', 'desc')
    ->orderBy('id', 'desc')
    ->get();

echo "Total data tidur: " . count($allTidur) . "\n\n";

foreach ($allTidur as $item) {
    echo "ID: " . $item->id . " | Tanggal: " . $item->tanggal . " | Durasi: " . $item->durasi_jam . " jam | Kualitas: " . $item->kualitas_tidur . "\n";
}

echo "\n=== CEK DATA AKTIVITAS (untuk user " . $user->id . ") ===\n";
$allAktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->orderBy('tanggal', 'desc')
    ->get();

echo "Total data aktivitas: " . count($allAktivitas) . "\n";
foreach ($allAktivitas as $item) {
    echo "ID: " . $item->id . " | Tanggal: " . $item->tanggal . " | JamTidur: " . $item->jam_tidur . " | Berat: " . $item->berat_badan . "\n";
}

echo "\n=== DATA HARI INI (2025-12-11) ===\n";
$todayTidur = \App\Models\TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', '2025-12-11')
    ->orderBy('id', 'desc')
    ->first();

if ($todayTidur) {
    echo "Durasi Hari Ini: " . $todayTidur->durasi_jam . " jam\n";
} else {
    echo "Tidak ada data hari ini\n";
}

echo "\n=== RATA-RATA 7 HARI ===\n";
$sevenDaysTidur = \App\Models\TidurUser::where('user_id', $user->id)
    ->orderBy('tanggal', 'desc')
    ->limit(7)
    ->get();

echo "Jumlah data 7 hari: " . count($sevenDaysTidur) . "\n";
$total = $sevenDaysTidur->sum('durasi_jam');
$average = count($sevenDaysTidur) > 0 ? round($total / count($sevenDaysTidur), 1) : 0;
echo "Total: " . $total . " jam\n";
echo "Rata-rata: " . $average . " jam\n";

foreach ($sevenDaysTidur as $item) {
    echo "  - " . $item->tanggal . ": " . $item->durasi_jam . " jam\n";
}
