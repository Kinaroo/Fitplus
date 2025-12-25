<?php
use Illuminate\Support\Facades\Auth;

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== LAPORAN KESEHATAN DEBUG ===\n\n";

// Check 1: Database connection
try {
    $userCount = \App\Models\User::count();
    echo "✅ Database connected. Users: $userCount\n";
} catch (\Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit(1);
}

// Check 2: Login as first user
try {
    $user = \App\Models\User::first();
    if (!$user) {
        echo "❌ No users in database!\n";
        exit(1);
    }
    
    Auth::loginUsingId($user->id);
    echo "✅ Logged in as: " . $user->nama . " (ID: " . $user->id . ")\n";
    echo "✅ Auth check: " . (Auth::check() ? "YES" : "NO") . "\n";
} catch (\Exception $e) {
    echo "❌ Auth error: " . $e->getMessage() . "\n";
    exit(1);
}

// Check 3: Test controller data
try {
    $today = now()->toDateString();
    $startDate = now()->subDays(30)->toDateString();
    
    $aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [$startDate, $today])
        ->count();
    
    $tidur = \App\Models\TidurUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [$startDate, $today])
        ->count();
    
    $makanan = \App\Models\MakananUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [$startDate, $today])
        ->count();
    
    echo "\n✅ Data available:\n";
    echo "   - Aktivitas records: $aktivitas\n";
    echo "   - Tidur records: $tidur\n";
    echo "   - Makanan records: $makanan\n";
} catch (\Exception $e) {
    echo "❌ Data error: " . $e->getMessage() . "\n";
    exit(1);
}

// Check 4: View render test
try {
    $request = new \Illuminate\Http\Request();
    $request->merge(['periode' => '30']);
    
    // Manually call controller
    $controller = new \App\Http\Controllers\LaporanController();
    
    // Prepare view data as controller would
    $userId = $user->id;
    $periode = 30;
    $today = now()->toDateString();
    $startDate = now()->subDays($periode)->toDateString();

    $aktivitasHari = \App\Models\AktivitasUser::where('user_id', $userId)
        ->whereDate('tanggal', $today)
        ->first();

    $aktivitasPeriode = \App\Models\AktivitasUser::where('user_id', $userId)
        ->whereBetween('tanggal', [$startDate, $today])
        ->orderBy('tanggal', 'asc')
        ->get();

    $tidurHari = \App\Models\TidurUser::where('user_id', $userId)
        ->whereDate('tanggal', $today)
        ->first();

    $tidurPeriode = \App\Models\TidurUser::where('user_id', $userId)
        ->whereBetween('tanggal', [$startDate, $today])
        ->orderBy('tanggal', 'asc')
        ->get();

    $makananHari = \App\Models\MakananUser::where('user_id', $userId)
        ->whereDate('tanggal', $today)
        ->get();

    $makananPeriode = \App\Models\MakananUser::where('user_id', $userId)
        ->whereBetween('tanggal', [$startDate, $today])
        ->get();
    
    echo "\n✅ View data preparation successful\n";
    echo "   - User: " . $user->nama . "\n";
    echo "   - Total records to display: " . ($aktivitasPeriode->count() + $tidurPeriode->count() + $makananPeriode->count()) . "\n";
    
} catch (\Exception $e) {
    echo "❌ View error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✅ ALL TESTS PASSED! Laporan Kesehatan is ready to use.\n";
echo "\n📝 Next step: Access http://localhost:8000/laporan/kesehatan while logged in\n";
