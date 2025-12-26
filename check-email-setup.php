<?php

// Check 1: ENV values
echo "=== STEP 1: CHECK .env VALUES ===\n";
echo "MAIL_MAILER: " . $_ENV['MAIL_MAILER'] ?? 'NOT SET' . "\n";
echo "MAIL_USERNAME: " . ($_ENV['MAIL_USERNAME'] ?? 'NOT SET') . "\n";
echo "MAIL_PASSWORD: " . (isset($_ENV['MAIL_PASSWORD']) && $_ENV['MAIL_PASSWORD'] !== 'your-app-password' ? 'SET (****)' : 'NOT SET / PLACEHOLDER') . "\n";
echo "MAIL_HOST: " . $_ENV['MAIL_HOST'] ?? 'NOT SET' . "\n";
echo "MAIL_FROM_ADDRESS: " . $_ENV['MAIL_FROM_ADDRESS'] ?? 'NOT SET' . "\n\n";

// Check 2: Config values from Laravel
echo "=== STEP 2: CHECK LARAVEL CONFIG ===\n";
echo "config('mail.default'): " . (defined('LARAVEL_START') ? config('mail.default') : 'NOT LOADED') . "\n";
echo "config('mail.from.address'): " . (defined('LARAVEL_START') ? config('mail.from.address') : 'NOT LOADED') . "\n\n";

// Check 3: File existence
echo "=== STEP 3: CHECK FILES ===\n";
echo "PasswordResetMail.php exists: " . (file_exists(dirname(__FILE__) . '/app/Mail/PasswordResetMail.php') ? 'YES' : 'NO') . "\n";
echo "password-reset.blade.php exists: " . (file_exists(dirname(__FILE__) . '/resources/views/emails/password-reset.blade.php') ? 'YES' : 'NO') . "\n\n";

echo "=== ACTION REQUIRED ===\n";
if (($_ENV['MAIL_USERNAME'] ?? null) === 'your-email@gmail.com' || 
    ($_ENV['MAIL_PASSWORD'] ?? null) === 'your-app-password') {
    echo "❌ ERROR: .env still has PLACEHOLDER values!\n";
    echo "   You MUST update these in .env:\n";
    echo "   - MAIL_USERNAME=your-email@gmail.com → YOUR ACTUAL EMAIL\n";
    echo "   - MAIL_PASSWORD=your-app-password → YOUR APP PASSWORD (16 chars)\n";
    echo "\n   After updating, RESTART the server!\n";
} else {
    echo "✅ .env looks correct. Check Laravel logs in storage/logs/laravel.log\n";
}
