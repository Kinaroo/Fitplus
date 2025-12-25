<?php
// test-auth.php - Check authentication status

// Cek apakah user sudah login
echo "Checking authentication status...\n";
echo "================================\n\n";

$user = auth()->user();

if ($user) {
    echo "✅ User sudah authenticated!\n";
    echo "   ID: " . $user->id . "\n";
    echo "   Email: " . $user->email . "\n";
    echo "   Nama: " . $user->nama . "\n";
} else {
    echo "❌ User TIDAK authenticated!\n";
    echo "   Silahkan login terlebih dahulu.\n";
    echo "\n   Redirect ke: /login\n";
}

echo "\n================================\n";
echo "Done!\n";
?>
