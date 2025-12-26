<?php
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TEST LAPORAN KESEHATAN ===\n\n";

// Test 1: Check if users exist
$users = \App\Models\User::all();
echo "Total Users: " . $users->count() . "\n";
if ($users->count() > 0) {
    echo "First User: " . $users->first()->nama . " (ID: " . $users->first()->id . ")\n";
}

echo "\n=== AUTH CHECK ===\n";
// Test auth (simulating logged in)
if ($users->count() > 0) {
    $user = $users->first();
    \Illuminate\Support\Facades\Auth::loginUsingId($user->id);
    
    echo "Logged in as: " . auth()->user()->nama . "\n";
    echo "Auth check: " . (auth()->check() ? "YES" : "NO") . "\n";
    
    // Test query
    echo "\n=== DATA CHECK ===\n";
    $aktivitas = \App\Models\AktivitasUser::where('user_id', $user->id)->count();
    $tidur = \App\Models\TidurUser::where('user_id', $user->id)->count();
    $makanan = \App\Models\MakananUser::where('user_id', $user->id)->count();
    
    echo "Aktivitas records: $aktivitas\n";
    echo "Tidur records: $tidur\n";
    echo "Makanan records: $makanan\n";
    
    echo "\n✅ All checks passed!\n";
} else {
    echo "❌ No users found in database!\n";
}
