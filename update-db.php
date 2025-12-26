<?php

use Illuminate\Database\Capsule\Manager as DB;

// Update table aktivitas_user to add new columns
$pdo = new PDO('mysql:host=127.0.0.1;dbname=fitplus', 'root', '');

$sql = "
ALTER TABLE aktivitas_user
ADD COLUMN IF NOT EXISTS umur INT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS berat_badan DECIMAL(5,2) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS tinggi_badan DECIMAL(5,2) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS jam_tidur DECIMAL(4,2) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS olahraga INT DEFAULT NULL
";

try {
    $pdo->exec($sql);
    echo "Database updated successfully!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
