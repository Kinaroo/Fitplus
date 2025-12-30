<?php
/**
 * Quick script to check and add missing columns to aktivitas_user table
 * Run this in your browser: http://localhost:8000/check-aktivitas-columns.php
 * Or via artisan: php artisan tinker then copy the code
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<pre>";
echo "=== CHECKING aktivitas_user TABLE COLUMNS ===\n\n";

// Check current columns
$columns = Schema::getColumnListing('aktivitas_user');
echo "Current columns in aktivitas_user:\n";
print_r($columns);

// Required columns for health data
$requiredColumns = ['umur', 'berat_badan', 'tinggi_badan', 'jam_tidur', 'olahraga'];
$missingColumns = [];

foreach ($requiredColumns as $col) {
    if (!in_array($col, $columns)) {
        $missingColumns[] = $col;
    }
}

if (empty($missingColumns)) {
    echo "\n✅ All required columns exist!\n";
} else {
    echo "\n❌ Missing columns: " . implode(', ', $missingColumns) . "\n";
    echo "\nAdding missing columns...\n";
    
    try {
        foreach ($missingColumns as $col) {
            $type = match($col) {
                'umur' => 'INT(11) DEFAULT NULL',
                'berat_badan' => 'DECIMAL(5,2) DEFAULT NULL',
                'tinggi_badan' => 'INT(11) DEFAULT NULL',
                'jam_tidur' => 'DECIMAL(3,1) DEFAULT NULL',
                'olahraga' => 'INT(11) DEFAULT NULL',
            };
            
            DB::statement("ALTER TABLE aktivitas_user ADD COLUMN `{$col}` {$type}");
            echo "  ✅ Added column: {$col}\n";
        }
        
        echo "\n✅ All missing columns have been added!\n";
    } catch (\Exception $e) {
        echo "\n❌ Error: " . $e->getMessage() . "\n";
    }
}

// Show some sample data
echo "\n=== SAMPLE DATA ===\n";
$data = DB::table('aktivitas_user')->limit(5)->get();
if ($data->count() > 0) {
    foreach ($data as $row) {
        print_r((array) $row);
    }
} else {
    echo "No data in aktivitas_user table yet.\n";
}

echo "</pre>";
