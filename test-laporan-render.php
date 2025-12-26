<?php
// Debug laporan kesehatan halaman - lihat apakah ada error

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->handle(
    $request = \Illuminate\Http\Request::capture()
);

// Set user
$user = \App\Models\User::find(1);
if (!$user) {
    echo "❌ User 1 not found\n";
    exit(1);
}

auth()->setUser($user);
echo "✓ User authenticated: {$user->nama}\n\n";

// Create request
$request = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');
$request->setUserResolver(function() { return auth()->user(); });

// Call controller
$controller = new \App\Http\Controllers\LaporanController();

try {
    echo "📝 Calling LaporanController::kesehatan()...\n";
    $response = $controller->kesehatan($request);
    
    echo "✓ Response received\n";
    echo "Response type: " . get_class($response) . "\n\n";
    
    if ($response instanceof \Illuminate\View\View) {
        echo "✓ View object created\n";
        
        // Get view data
        $data = $response->getData();
        echo "✓ View data retrieved\n";
        echo "  Keys: " . implode(', ', array_keys($data)) . "\n\n";
        
        // Check user
        if (isset($data['user'])) {
            echo "✓ User data: {$data['user']->nama}\n";
        } else {
            echo "✗ User data MISSING!\n";
        }
        
        // Check stats
        if (isset($data['stats'])) {
            echo "✓ Stats data: " . count($data['stats']) . " keys\n";
            echo "  Sample: berat_hari={$data['stats']['berat_hari']}, tidur_hari={$data['stats']['tidur_hari']}\n";
        } else {
            echo "✗ Stats data MISSING!\n";
        }
        
        // Check rekomendasi
        if (isset($data['rekomendasi'])) {
            echo "✓ Rekomendasi: " . count($data['rekomendasi']) . " items\n";
        } else {
            echo "✗ Rekomendasi MISSING!\n";
        }
        
        // Try to render the view
        echo "\n📊 Attempting to render view...\n";
        try {
            $rendered = $response->render();
            echo "✓ View rendered successfully\n";
            echo "  Length: " . strlen($rendered) . " bytes\n";
            
            // Check for content
            if (strpos($rendered, 'Laporan Kesehatan') !== false) {
                echo "✓ Title found in output\n";
            } else {
                echo "✗ Title NOT found in output\n";
            }
            
            if (strpos($rendered, 'Berat Badan') !== false) {
                echo "✓ Statistics section found\n";
            } else {
                echo "✗ Statistics section NOT found\n";
            }
            
            if (strpos($rendered, 'Indeks Massa Tubuh') !== false) {
                echo "✓ IMT section found\n";
            } else {
                echo "✗ IMT section NOT found\n";
            }
            
        } catch (\Exception $e) {
            echo "✗ Error rendering view: " . $e->getMessage() . "\n";
            echo "  File: " . $e->getFile() . " (line {$e->getLine()})\n";
            echo "\nFull error:\n";
            echo $e->getTraceAsString();
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error calling controller: " . $e->getMessage() . "\n";
    echo "  File: " . $e->getFile() . " (line {$e->getLine()})\n";
    echo "\nFull error:\n";
    echo $e->getTraceAsString();
}
?>
