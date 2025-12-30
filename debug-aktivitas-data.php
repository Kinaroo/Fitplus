<?php
/**
 * Debug script to check aktivitas_user data
 * Run: php debug-aktivitas-data.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<pre>";
echo "=== AKTIVITAS_USER TABLE DEBUG ===\n\n";

// 1. Check columns
echo "1. TABLE COLUMNS:\n";
$columns = Schema::getColumnListing('aktivitas_user');
print_r($columns);

// 2. Check all data
echo "\n2. ALL DATA IN TABLE:\n";
$data = DB::table('aktivitas_user')->get();
foreach ($data as $row) {
    echo "---\n";
    print_r((array) $row);
}

// 3. Check today's data specifically
echo "\n3. TODAY'S DATA (User ID 1):\n";
$today = now()->toDateString();
echo "Today: {$today}\n";
$todayData = DB::table('aktivitas_user')
    ->where('user_id', 1)
    ->whereDate('tanggal', $today)
    ->first();
    
if ($todayData) {
    print_r((array) $todayData);
} else {
    echo "No data found for today.\n";
}

// 4. Try to insert test data to verify columns work
echo "\n4. TESTING INSERT WITH ALL COLUMNS:\n";
try {
    $testId = DB::table('aktivitas_user')->insertGetId([
        'user_id' => 1,
        'tanggal' => $today,
        'umur' => 25,
        'berat_badan' => 70.5,
        'tinggi_badan' => 175,
        'jam_tidur' => 7.5,
        'olahraga' => 30,
    ]);
    echo "✅ Test insert successful! ID: {$testId}\n";
    
    // Read it back
    $inserted = DB::table('aktivitas_user')->find($testId);
    print_r((array) $inserted);
    
    // Delete test data
    DB::table('aktivitas_user')->where('id', $testId)->delete();
    echo "\n(Test data deleted)\n";
    
} catch (\Exception $e) {
    echo "❌ Insert failed: " . $e->getMessage() . "\n";
}

echo "\n=== END DEBUG ===\n";
echo "</pre>";
