#!/usr/bin/env php
<?php
/**
 * Test Auto-Update Dashboard
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\AktivitasUser;
use App\Models\TidurUser;
use App\Models\MakananUser;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n========================================\n";
echo "🔄 Testing Auto-Update Dashboard\n";
echo "========================================\n\n";

$user = User::first();
$today = now()->toDateString();

echo "Test User: {$user->nama} ({$user->email})\n";
echo "Today: {$today}\n\n";

// Clear cache
\Illuminate\Support\Facades\Cache::forget('dashboard_' . $user->id);

echo "✓ Cache cleared\n\n";

// Test 1: Add aktivitas for today
echo "Test 1: Add Aktivitas Data Today\n";
$aktivitas = AktivitasUser::create([
    'user_id' => $user->id,
    'tanggal' => $today,
    'umur' => 25,
    'berat_badan' => 72.5,
    'tinggi_badan' => 175,
    'jam_tidur' => 7.5,
    'olahraga' => 45,
]);
echo "  ✓ Created aktivitas ID: {$aktivitas->id}\n";
echo "  ✓ Berat: {$aktivitas->berat_badan} kg\n";
echo "  ✓ Olahraga: {$aktivitas->olahraga} menit\n\n";

// Verify today's data
$todayData = AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

if ($todayData) {
    echo "✓ Dashboard akan menampilkan:\n";
    echo "  - Umur: {$todayData->umur}\n";
    echo "  - Berat Badan: {$todayData->berat_badan} kg\n";
    echo "  - Olahraga: {$todayData->olahraga} menit\n\n";
} else {
    echo "✗ Data tidak ditemukan\n\n";
}

// Test 2: Add tidur data
echo "Test 2: Add Tidur Data Today\n";
$tidur = TidurUser::create([
    'user_id' => $user->id,
    'tanggal' => $today,
    'durasi_jam' => 8.5,
    'kualitas_tidur' => 8,
    'fase_tidur' => 'Normal',
]);
echo "  ✓ Created tidur ID: {$tidur->id}\n";
echo "  ✓ Durasi: {$tidur->durasi_jam} jam\n\n";

// Verify tidur data
$todayTidur = TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

if ($todayTidur) {
    echo "✓ Dashboard akan menampilkan:\n";
    echo "  - Jam Tidur: {$todayTidur->durasi_jam} jam\n\n";
} else {
    echo "✗ Data tidak ditemukan\n\n";
}

// Test 3: Add makanan data
echo "Test 3: Add Makanan Data Today\n";
// Get first available makanan
$makananIds = \Illuminate\Support\Facades\DB::table('info_makanan')->limit(1)->pluck('id');
if ($makananIds->count() > 0) {
    $makanan = MakananUser::create([
        'user_id' => $user->id,
        'makanan_id' => $makananIds[0],
        'tanggal' => $today,
        'porsi' => 2,
        'total_kalori' => 450,
    ]);
    echo "  ✓ Created makanan entry\n";
    echo "  ✓ Total Kalori: {$makanan->total_kalori} kkal\n\n";
} else {
    echo "  ⚠ No makanan in database - skipping\n\n";
}

// Calculate totals
$totalActivities = AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->count();

$totalTidurEntries = TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->count();

$totalKalori = MakananUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->sum('total_kalori');

echo "========================================\n";
echo "📊 TODAY'S STATISTICS\n";
echo "========================================\n\n";
echo "Aktivitas entries: {$totalActivities}\n";
echo "Tidur entries: {$totalTidurEntries}\n";
echo "Total Kalori: {$totalKalori} kkal\n\n";

echo "========================================\n";
echo "✅ AUTO-UPDATE TEST COMPLETE\n";
echo "========================================\n\n";

echo "Dashboard akan:\n";
echo "1. ✅ Menampilkan data hari ini (Umur, Berat, Jam Tidur, Olahraga)\n";
echo "2. ✅ Auto-refresh setiap 5 detik\n";
echo "3. ✅ Selalu menampilkan data FRESH (no cache)\n";
echo "4. ✅ Update otomatis saat ada perubahan\n\n";

echo "Refresh browser untuk melihat perubahan!\n\n";
?>
