<?php

// Test file to verify data is being saved correctly
require __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get user and test data
$user = \App\Models\User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "No test user found. Creating one...\n";
    $user = \App\Models\User::create([
        'nama' => 'Test User',
        'email' => 'test@example.com',
        'password_hash' => \Illuminate\Support\Facades\Hash::make('password'),
        'tanggal_daftar' => now()->toDateString(),
    ]);
    echo "User created with ID: {$user->id}\n";
}

$today = now()->toDateString();

echo "================================\n";
echo "TEST: Health Data Verification\n";
echo "================================\n";
echo "User: {$user->nama} (ID: {$user->id})\n";
echo "Date: {$today}\n";
echo "================================\n\n";

// Check aktivitas_user table
echo "1. Checking AktivitasUser table:\n";
$aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

if ($aktivitas) {
    echo "   ✓ Data found!\n";
    echo "   - ID: {$aktivitas->id}\n";
    echo "   - User ID: {$aktivitas->user_id}\n";
    echo "   - Umur: {$aktivitas->umur}\n";
    echo "   - Berat: {$aktivitas->berat_badan} kg\n";
    echo "   - Tinggi: {$aktivitas->tinggi_badan} cm\n";
    echo "   - Jam Tidur: {$aktivitas->jam_tidur} jam\n";
    echo "   - Olahraga: {$aktivitas->olahraga} menit\n";
} else {
    echo "   ✗ NO DATA in aktivitas_user for today\n";
}

echo "\n";

// Check tidur_user table
echo "2. Checking TidurUser table:\n";
$tidur = \App\Models\TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

if ($tidur) {
    echo "   ✓ Data found!\n";
    echo "   - ID: {$tidur->id}\n";
    echo "   - User ID: {$tidur->user_id}\n";
    echo "   - Durasi Jam: {$tidur->durasi_jam}\n";
    echo "   - Tanggal: {$tidur->tanggal}\n";
    echo "   - Kualitas: {$tidur->kualitas_tidur}\n";
} else {
    echo "   ✗ NO DATA in tidur_user for today\n";
}

echo "\n";

// Test create logic
echo "3. Test: Creating new health data...\n";
try {
    $newAktivitas = \App\Models\AktivitasUser::create([
        'user_id' => $user->id,
        'tanggal' => $today,
        'umur' => 25,
        'berat_badan' => 70,
        'tinggi_badan' => 170,
        'jam_tidur' => 8,
        'olahraga' => 30,
    ]);
    echo "   ✓ AktivitasUser created: ID {$newAktivitas->id}\n";
    
    $newTidur = \App\Models\TidurUser::updateOrCreate(
        [
            'user_id' => $user->id,
            'tanggal' => $today,
        ],
        [
            'durasi_jam' => 8,
            'kualitas_tidur' => 'Baik',
        ]
    );
    echo "   ✓ TidurUser created/updated: ID {$newTidur->id}\n";
} catch (\Exception $e) {
    echo "   ✗ Error creating data: {$e->getMessage()}\n";
}

echo "\n";

// Verify after creation
echo "4. Verify data after creation:\n";
$aktivitasCheck = \App\Models\AktivitasUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->latest()
    ->first();

$tidurCheck = \App\Models\TidurUser::where('user_id', $user->id)
    ->whereDate('tanggal', $today)
    ->first();

echo "   AktivitasUser: " . ($aktivitasCheck ? "✓ {$aktivitasCheck->berat_badan} kg" : "✗ Not found") . "\n";
echo "   TidurUser: " . ($tidurCheck ? "✓ {$tidurCheck->durasi_jam} jam" : "✗ Not found") . "\n";

echo "\n";
echo "================================\n";
echo "Test completed!\n";
echo "================================\n";
