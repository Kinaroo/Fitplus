<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get user
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();
if (!$user) {
    echo "User tidak ditemukan\n";
    exit;
}

echo "User: " . $user->nama . " (ID: " . $user->id . ")\n";
echo "====================================\n\n";

// Get tidur data (7 days)
$tidurData = \App\Models\TidurUser::where('user_id', $user->id)
    ->orderBy('tanggal', 'desc')
    ->limit(7)
    ->get();

echo "Tidur data count: " . count($tidurData) . "\n\n";

foreach ($tidurData as $item) {
    echo "Tanggal: " . $item->tanggal . " | Durasi: " . $item->durasi_jam . " jam\n";
}

echo "\n====================================\n";
$totalTidur = $tidurData->sum('durasi_jam');
$rataTidur = 0;
if ($tidurData->count() > 0) {
    $rataTidur = round($totalTidur / $tidurData->count(), 1);
}

echo "Total tidur 7 hari: " . $totalTidur . " jam\n";
echo "Rata-rata tidur: " . $rataTidur . " jam\n";
