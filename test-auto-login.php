<?php
// Simple auto-login + test laporan

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create a login request
$loginRequest = \Illuminate\Http\Request::create('/login', 'POST');
$loginRequest->merge([
    'email' => 'najeroo@gmail.com',
    'password' => 'password123',  // Make sure this is correct
    '_token' => session()->token(),
]);

echo "=== AUTO LOGIN TEST ===\n\n";

// Check if user exists
$user = \App\Models\User::where('email', 'najeroo@gmail.com')->first();
if (!$user) {
    echo "❌ User dengan email najeroo@gmail.com tidak ditemukan\n";
    echo "\nDaftar user yang tersedia:\n";
    \App\Models\User::select('id', 'nama', 'email')->get()->each(function($u) {
        echo "  - ID {$u->id}: {$u->nama} ({$u->email})\n";
    });
    exit(1);
}

echo "✓ User ditemukan: {$user->nama} ({$user->email})\n";
echo "  ID: {$user->id}\n";
echo "  Password hash: " . substr($user->password_hash, 0, 15) . "...\n\n";

// Try to login
echo "Mencoba login dengan password 'password123'...\n";
if (\Illuminate\Support\Facades\Hash::check('password123', $user->password_hash)) {
    echo "✓ Password cocok!\n";
    auth()->loginUsingId($user->id);
    echo "✓ Auth login successful\n";
    echo "  Auth check: " . (auth()->check() ? 'YES' : 'NO') . "\n";
    echo "  Authenticated user: " . auth()->user()?->nama . "\n\n";
    
    // Now test laporan
    echo "Testing laporan kesehatan access...\n";
    $laporanRequest = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');
    $laporanRequest->setUserResolver(function() { return auth()->user(); });
    
    $controller = new \App\Http\Controllers\LaporanController();
    try {
        $response = $controller->kesehatan($laporanRequest);
        echo "✓ Laporan controller berhasil dipanggil\n";
        echo "  Response type: " . get_class($response) . "\n";
        
        if ($response instanceof \Illuminate\View\View) {
            $data = $response->getData();
            echo "  View data: " . implode(', ', array_keys($data)) . "\n";
            echo "\n✓✓✓ LAPORAN KESEHATAN SIAP DITAMPILKAN ✓✓✓\n";
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ Password TIDAK cocok!\n";
    echo "\nMungkin perlu setup password user atau cek user ID\n";
    echo "\nMencoba dengan user ID 1 langsung...\n";
    
    auth()->loginUsingId(1);
    echo "✓ Login with ID 1 successful\n";
    echo "  Auth check: " . (auth()->check() ? 'YES' : 'NO') . "\n";
    echo "  User: " . auth()->user()?->nama . "\n";
}
?>
