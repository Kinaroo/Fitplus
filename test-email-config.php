<?php

use Illuminate\Support\Facades\Mail;

// Test email configuration
echo "Testing Email Configuration...\n\n";

echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

if (config('mail.default') === 'smtp') {
    echo "SMTP Configuration:\n";
    echo "HOST: " . config('mail.mailers.smtp.host') . "\n";
    echo "PORT: " . config('mail.mailers.smtp.port') . "\n";
    echo "USERNAME: " . config('mail.mailers.smtp.username') . "\n";
    echo "ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
    echo "\n";
    
    if (config('mail.mailers.smtp.username') === null || config('mail.mailers.smtp.password') === null) {
        echo "❌ ERROR: MAIL_USERNAME or MAIL_PASSWORD not configured!\n";
        echo "   Update your .env file with actual Gmail credentials\n";
    } else {
        echo "✅ SMTP credentials configured\n";
    }
} else {
    echo "❌ ERROR: MAIL_MAILER is not set to 'smtp'\n";
    echo "   Current value: " . config('mail.default') . "\n";
}

echo "\n--- End of Test ---\n";
