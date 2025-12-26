<?php
// Comprehensive test of all features

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->handle(
    $request = \Illuminate\Http\Request::capture()
);

echo "=== FitPlus System Health Check ===\n\n";

// 1. Check users
$userCount = \App\Models\User::count();
echo "1. Users in System: $userCount\n";
$users = \App\Models\User::select('id', 'nama', 'email')->limit(3)->get();
foreach ($users as $user) {
    echo "   - User {$user->id}: {$user->nama} ({$user->email})\n";
}

// 2. Check aktivitas data
$aktivitasCount = \App\Models\AktivitasUser::count();
echo "\n2. Aktivitas Records: $aktivitasCount\n";
$recentAktivitas = \App\Models\AktivitasUser::latest('tanggal')->limit(3)->get();
foreach ($recentAktivitas as $a) {
    echo "   - User {$a->user_id}: {$a->tanggal} (Berat: {$a->berat_badan} kg, Olahraga: {$a->olahraga} min)\n";
}

// 3. Check tidur data
$tidurCount = \App\Models\TidurUser::count();
echo "\n3. Tidur Records: $tidurCount\n";
$recentTidur = \App\Models\TidurUser::latest('tanggal')->limit(3)->get();
foreach ($recentTidur as $t) {
    echo "   - User {$t->user_id}: {$t->tanggal} (Durasi: {$t->durasi_jam} jam)\n";
}

// 4. Check makanan data
$makananCount = \App\Models\MakananUser::count();
echo "\n4. Makanan Records: $makananCount\n";
$recentMakanan = \App\Models\MakananUser::latest('tanggal')->limit(3)->get();
foreach ($recentMakanan as $m) {
    echo "   - User {$m->user_id}: {$m->tanggal} (Kalori: {$m->total_kalori}, Portion: {$m->porsi})\n";
}

// 5. Test laporan for user 1
echo "\n5. Testing Laporan Kesehatan for User 1:\n";
$user = \App\Models\User::find(1);
if ($user) {
    auth()->setUser($user);
    
    $controller = new \App\Http\Controllers\LaporanController();
    $request = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');
    $request->setUserResolver(function() { return auth()->user(); });
    
    try {
        $response = $controller->kesehatan($request);
        $data = $response->getData();
        $stats = $data['stats'];
        
        echo "   ✓ Laporan rendered successfully\n";
        echo "   ✓ Stats: Berat Hari: {$stats['berat_hari']}, Tidur Hari: {$stats['tidur_hari']}, Olahraga: {$stats['olahraga_hari']} min\n";
        echo "   ✓ Period Stats: Berat Avg: {$stats['berat_periode_avg']} kg, Tidur Avg: {$stats['tidur_periode_avg']} jam\n";
        echo "   ✓ Rekomendasi Count: " . count($data['rekomendasi']) . "\n";
    } catch (\Exception $e) {
        echo "   ✗ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Check Complete ===\n";
?>
