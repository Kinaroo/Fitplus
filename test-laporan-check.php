<?php

// Simple test to check if laporan view renders
$uri = 'http://127.0.0.1:8000/laporan/kesehatan';

// Get the page content
$content = @file_get_contents($uri);

if ($content === false) {
    echo "❌ Error: Cannot access $uri\n";
    exit(1);
}

// Check page length
echo "✓ Page loaded successfully\n";
echo "Page size: " . strlen($content) . " bytes\n\n";

// Check for key elements
$checks = [
    'DOCTYPE html' => 'HTML document declaration',
    'Laporan Kesehatan' => 'Page title',
    'Berat Badan Rata-rata' => 'Statistics section',
    'Indeks Massa Tubuh' => 'IMT section',
    'Rekomendasi & Saran' => 'Recommendations section',
    'Target Kesehatan' => 'Health targets section',
];

echo "Checking for page elements:\n";
foreach ($checks as $search => $desc) {
    if (strpos($content, $search) !== false) {
        echo "✓ Found: $desc\n";
    } else {
        echo "✗ Missing: $desc\n";
    }
}

// Check for error messages
echo "\nChecking for errors:\n";
if (strpos($content, 'Error') !== false || strpos($content, 'error') !== false) {
    echo "⚠ Page might contain errors\n";
} else {
    echo "✓ No obvious errors detected\n";
}

// Check for authentication issues
if (strpos($content, 'login') !== false && strpos($content, 'Silahkan login') !== false) {
    echo "⚠ Authentication redirect detected\n";
} else {
    echo "✓ Page appears to be authenticated\n";
}

// Show snippet of content
echo "\nFirst 500 characters:\n";
echo substr($content, 0, 500) . "\n";
?>
