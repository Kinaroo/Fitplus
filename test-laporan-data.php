<?php
// Test to manually check laporan data

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->handle(
    $request = \Illuminate\Http\Request::capture()
);

// Set user for testing
$user = \App\Models\User::find(1);
if (!$user) {
    echo "❌ User 1 not found\n";
    exit(1);
}

auth()->setUser($user);

echo "✓ User authenticated: " . $user->nama . "\n\n";

// Manually run the controller logic
$controller = new \App\Http\Controllers\LaporanController();
$request = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');
$request->setUserResolver(function() { return auth()->user(); });

try {
    // Get aktivitas data
    $aktivitasHari = \App\Models\AktivitasUser::where('user_id', $user->id)
        ->whereDate('tanggal', now()->toDateString())
        ->first();
    
    $aktivitasPeriode = \App\Models\AktivitasUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [now()->subDays(30)->toDateString(), now()->toDateString()])
        ->get();
    
    echo "Aktivitas Data:\n";
    echo "  - Today: " . ($aktivitasHari ? "✓ Has data (berat=" . $aktivitasHari->berat_badan . ")" : "✗ No data") . "\n";
    echo "  - Period (30 days): " . $aktivitasPeriode->count() . " records\n\n";
    
    // Get tidur data
    $tidurHari = \App\Models\TidurUser::where('user_id', $user->id)
        ->whereDate('tanggal', now()->toDateString())
        ->first();
    
    $tidurPeriode = \App\Models\TidurUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [now()->subDays(30)->toDateString(), now()->toDateString()])
        ->get();
    
    echo "Tidur Data:\n";
    echo "  - Today: " . ($tidurHari ? "✓ Has data (durasi=" . $tidurHari->durasi_jam . ")" : "✗ No data") . "\n";
    echo "  - Period (30 days): " . $tidurPeriode->count() . " records\n\n";
    
    // Get makanan data
    $makananHari = \App\Models\MakananUser::where('user_id', $user->id)
        ->whereDate('tanggal', now()->toDateString())
        ->get();
    
    $makananPeriode = \App\Models\MakananUser::where('user_id', $user->id)
        ->whereBetween('tanggal', [now()->subDays(30)->toDateString(), now()->toDateString()])
        ->get();
    
    echo "Makanan Data:\n";
    echo "  - Today: " . $makananHari->count() . " items\n";
    echo "  - Period (30 days): " . $makananPeriode->count() . " items\n\n";
    
    // Test view rendering
    $response = $controller->kesehatan($request);
    
    echo "Response Type: " . get_class($response) . "\n";
    
    if ($response instanceof \Illuminate\View\View) {
        echo "✓ View returned successfully\n";
        echo "View data keys: " . implode(', ', array_keys($response->getData())) . "\n\n";
        
        // Check stats
        $stats = $response->getData()['stats'] ?? [];
        echo "Stats Array:\n";
        foreach ($stats as $key => $value) {
            echo "  $key: " . (is_numeric($value) ? $value : "\"$value\"") . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
?>
