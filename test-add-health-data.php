<?php
/**
 * Test script untuk simulasi tambah data kesehatan
 * Run: php test-add-health-data.php
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AktivitasUser;
use App\Models\TidurUser;
use Illuminate\Support\Facades\Auth;

echo "=== TEST: Add Health Data ===\n\n";

// Get user ID 7 (pajril@gmail)
$user = User::find(7);
if (!$user) {
    echo "❌ User ID 7 tidak ditemukan\n";
    exit;
}

echo "✓ User: {$user->nama} (ID: {$user->id}, Email: {$user->email})\n\n";

$today = now()->toDateString();
echo "✓ Testing date: {$today}\n\n";

// Simulate the form input
$formData = [
    'tanggal' => $today,
    'umur' => 25,
    'berat_badan' => 70.5,
    'tinggi_badan' => 170,
    'tidur' => 8.5,
    'olahraga' => 45,
];

echo "Input data:\n";
foreach ($formData as $key => $value) {
    echo "  - {$key}: {$value}\n";
}

echo "\n";

// Manually execute what the controller does
try {
    // 1. Create aktivitas_user
    echo "1. Creating AktivitasUser record...\n";
    $aktivitas = AktivitasUser::create([
        'user_id' => $user->id,
        'tanggal' => $formData['tanggal'],
        'umur' => $formData['umur'],
        'berat_badan' => $formData['berat_badan'],
        'tinggi_badan' => $formData['tinggi_badan'],
        'jam_tidur' => $formData['tidur'],
        'olahraga' => $formData['olahraga'],
    ]);
    echo "   ✓ AktivitasUser created (ID: {$aktivitas->id})\n";
    
    // 2. Create tidur_user
    echo "\n2. Creating TidurUser record...\n";
    $tidur = TidurUser::updateOrCreate(
        [
            'user_id' => $user->id,
            'tanggal' => $formData['tanggal'],
        ],
        [
            'durasi_jam' => (float) $formData['tidur'],
            'kualitas_tidur' => 8, // INT value (scale 1-10)
        ]
    );
    echo "   ✓ TidurUser created/updated (ID: {$tidur->id})\n";
    echo "   - durasi_jam: {$tidur->durasi_jam}\n";
    echo "   - tanggal: {$tidur->tanggal}\n";
    
} catch (\Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n";
    echo "   Stack: {$e->getTraceAsString()}\n";
    exit;
}

echo "\n";

// Verify data was created
echo "3. Verifying data in database...\n";

$aktivitasCheck = AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->latest('id')
    ->first();

if ($aktivitasCheck) {
    echo "   ✓ AktivitasUser found:\n";
    echo "     - ID: {$aktivitasCheck->id}\n";
    echo "     - Berat: {$aktivitasCheck->berat_badan} kg\n";
    echo "     - JamTidur: {$aktivitasCheck->jam_tidur}\n";
} else {
    echo "   ❌ AktivitasUser NOT FOUND\n";
}

echo "\n";

$tidurCheck = TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

if ($tidurCheck) {
    echo "   ✓ TidurUser found:\n";
    echo "     - ID: {$tidurCheck->id}\n";
    echo "     - Durasi: {$tidurCheck->durasi_jam} jam\n";
    echo "     - Kualitas: {$tidurCheck->kualitas_tidur}\n";
} else {
    echo "   ❌ TidurUser NOT FOUND\n";
}

echo "\n";

// Simulate dashboard query
echo "4. Simulating dashboard query...\n";

$todayData = AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

$todayTidur = TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

echo "   Dashboard will display:\n";
echo "   - Umur: " . ($todayData?->umur ?? '-') . " tahun\n";
echo "   - Berat: " . ($todayData?->berat_badan ?? '-') . " kg\n";
echo "   - Jam Tidur: " . ($todayTidur?->durasi_jam ?? '-') . " jam ✓\n";
echo "   - Olahraga: " . ($todayData?->olahraga ?? '-') . " menit\n";

echo "\n=== TEST COMPLETE ===\n";
?>
