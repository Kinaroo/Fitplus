<?php
// Monitor laporan kesehatan page untuk melihat apa yang sedang terjadi

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Setup middleware untuk capture response
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create request ke laporan kesehatan
$request = \Illuminate\Http\Request::create('/laporan/kesehatan', 'GET');

// Handle request
$response = $kernel->handle($request);

echo "=== LAPORAN KESEHATAN PAGE DIAGNOSIS ===\n\n";

echo "1. Response Status:\n";
echo "   Status Code: " . $response->getStatusCode() . "\n";
echo "   Status Text: " . $response->getStatusCode() . "\n\n";

echo "2. Response Headers:\n";
$headers = $response->headers;
echo "   Content-Type: " . $headers->get('content-type') . "\n";
echo "   Content-Length: " . strlen($response->getContent()) . " bytes\n";
echo "   Cache-Control: " . $headers->get('cache-control') . "\n\n";

echo "3. Response Content Analysis:\n";
$content = $response->getContent();
$contentLength = strlen($content);
echo "   Total length: $contentLength bytes\n";

if ($contentLength < 100) {
    echo "   ✗ Content TERLALU KECIL - mungkin error atau redirect\n";
    echo "   Content: " . substr($content, 0, 500) . "\n";
} else {
    echo "   ✓ Content seems normal size\n";
    
    // Check for error messages
    $errorPatterns = [
        'Fatal error' => 'Fatal error',
        'Parse error' => 'Parse error',
        'syntax error' => 'Syntax error',
        'undefined' => 'Undefined variable/function',
        'Call to a member function on null' => 'Null object call',
    ];
    
    echo "   Checking for errors...\n";
    $hasError = false;
    foreach ($errorPatterns as $pattern => $desc) {
        if (stripos($content, $pattern) !== false) {
            echo "     ✗ FOUND: $desc\n";
            $hasError = true;
        }
    }
    
    if (!$hasError) {
        echo "     ✓ No error messages found\n";
    }
    
    // Check for content sections
    echo "\n   Checking for content sections...\n";
    $sections = [
        'Laporan Kesehatan' => 'Title',
        'Berat Badan' => 'Statistics',
        'Indeks Massa Tubuh' => 'IMT',
        'Rekomendasi' => 'Recommendations',
        'FitPlus' => 'Branding',
        'Dashboard' => 'Navigation',
    ];
    
    foreach ($sections as $search => $desc) {
        if (stripos($content, $search) !== false) {
            echo "     ✓ Found: $desc\n";
        } else {
            echo "     ✗ Missing: $desc\n";
        }
    }
}

echo "\n4. Response Sample (first 1000 chars):\n";
echo substr($content, 0, 1000) . "\n...\n";

// Check if redirecting
if ($response->isRedirect()) {
    echo "\n5. ⚠ REDIRECT DETECTED\n";
    echo "   Redirect to: " . $response->headers->get('location') . "\n";
}

// Terminate kernel properly
$kernel->terminate($request, $response);
?>
