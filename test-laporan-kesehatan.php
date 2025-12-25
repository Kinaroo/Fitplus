<?php

/**
 * Testing Script untuk Laporan Kesehatan
 * File: test-laporan-kesehatan.php
 * 
 * Jalankan: php artisan tinker < test-laporan-kesehatan.php
 * Atau: php test-laporan-kesehatan.php (jika di root project)
 */

// Pastikan user sudah authenticated
$user = auth()->user() ?? \App\Models\User::first();

if (!$user) {
    echo "❌ Tidak ada user untuk testing\n";
    exit;
}

echo "✅ Testing Laporan Kesehatan\n";
echo "=============================\n\n";

// Test 1: Akses Controller
echo "1️⃣  Testing LaporanController...\n";
$controller = new \App\Http\Controllers\LaporanController();
echo "   ✓ Controller berhasil diload\n\n";

// Test 2: Query Data
echo "2️⃣  Testing Data Query...\n";

$today = now()->toDateString();
$weekAgo = now()->subDays(7)->toDateString();
$monthAgo = now()->subDays(30)->toDateString();

$aktivitasHari = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();
echo "   • Aktivitas hari ini: " . ($aktivitasHari ? "✓ Ada" : "✗ Tidak ada") . "\n";

$tidurHari = \App\Models\TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();
echo "   • Tidur hari ini: " . ($tidurHari ? "✓ Ada" : "✗ Tidak ada") . "\n";

$makananHari = \App\Models\MakananUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->get();
echo "   • Makanan hari ini: " . ($makananHari->count() > 0 ? "✓ {$makananHari->count()} item" : "✗ Tidak ada") . "\n\n";

// Test 3: Data Minggu
echo "3️⃣  Testing Data Periode...\n";

$aktivitasMinggu = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->whereBetween('tanggal', [$weekAgo, $today])
    ->get();
echo "   • Aktivitas 7 hari: " . $aktivitasMinggu->count() . " record\n";

$tidurMinggu = \App\Models\TidurUser::where('user_id', $user->id)
    ->whereBetween('tanggal', [$weekAgo, $today])
    ->get();
echo "   • Tidur 7 hari: " . $tidurMinggu->count() . " record\n";

$makananMinggu = \App\Models\MakananUser::where('user_id', $user->id)
    ->whereBetween('tanggal', [$weekAgo, $today])
    ->get();
echo "   • Makanan 7 hari: " . $makananMinggu->count() . " record\n\n";

// Test 4: Kalkulasi Statistik
echo "4️⃣  Testing Kalkulasi Statistik...\n";

if ($aktivitasMinggu->count() > 0) {
    $beratAvg = round($aktivitasMinggu->avg('berat_badan'), 1);
    echo "   ✓ Rata-rata berat: $beratAvg kg\n";
}

if ($tidurMinggu->count() > 0) {
    $tidurAvg = round($tidurMinggu->avg('durasi_jam'), 1);
    echo "   ✓ Rata-rata tidur: $tidurAvg jam\n";
}

$totalOlahraga = $aktivitasMinggu->sum('olahraga');
echo "   ✓ Total olahraga: $totalOlahraga menit\n";

$totalKalori = $makananMinggu->sum('total_kalori');
echo "   ✓ Total kalori: $totalKalori kkal\n\n";

// Test 5: IMT Calculation
echo "5️⃣  Testing IMT Calculation...\n";
if ($aktivitasMinggu->count() > 0 && $user->tinggi) {
    $berat = $aktivitasMinggu->avg('berat_badan');
    $tinggi = $user->tinggi;
    $imt = round($berat / (($tinggi / 100) ** 2), 1);
    
    $kategori = 'Tidak terukur';
    if ($imt < 18.5) $kategori = 'Kurus';
    elseif ($imt < 25) $kategori = 'Normal';
    elseif ($imt < 30) $kategori = 'Gemuk';
    else $kategori = 'Obesitas';
    
    echo "   • Berat: $berat kg\n";
    echo "   • Tinggi: $tinggi cm\n";
    echo "   ✓ IMT: $imt ($kategori)\n\n";
} else {
    echo "   ✗ Data tidak cukup untuk kalkulasi IMT\n\n";
}

// Test 6: Route Test
echo "6️⃣  Testing Route...\n";
$route = route('laporan.kesehatan');
echo "   ✓ Route tersedia: $route\n\n";

// Summary
echo "=============================\n";
echo "✅ Testing Selesai!\n";
echo "\nCatatan:\n";
echo "- Pastikan ada data minimal di tabel aktivitas_users, tidur_users, makanan_users\n";
echo "- Jalankan: php artisan migrate (jika belum)\n";
echo "- Akses via: " . config('app.url') . "/laporan/kesehatan\n";
?>
