<?php
// Script untuk update database schema
$host = '127.0.0.1';
$db = 'fitplus';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add columns to akun_user table
    $queries = [
        // Add columns to akun_user if they don't exist
        "ALTER TABLE `akun_user` ADD COLUMN IF NOT EXISTS `berat_badan` DECIMAL(5,2) NULL DEFAULT NULL",
        "ALTER TABLE `akun_user` ADD COLUMN IF NOT EXISTS `tinggi_badan` DECIMAL(5,2) NULL DEFAULT NULL",
        
        // Add columns to aktivitas_user if they don't exist
        "ALTER TABLE `aktivitas_user` ADD COLUMN IF NOT EXISTS `umur` INT(11) NULL DEFAULT NULL",
        "ALTER TABLE `aktivitas_user` ADD COLUMN IF NOT EXISTS `berat_badan` DECIMAL(5,2) NULL DEFAULT NULL",
        "ALTER TABLE `aktivitas_user` ADD COLUMN IF NOT EXISTS `tinggi_badan` DECIMAL(5,2) NULL DEFAULT NULL",
        "ALTER TABLE `aktivitas_user` ADD COLUMN IF NOT EXISTS `jam_tidur` DECIMAL(4,2) NULL DEFAULT NULL",
        "ALTER TABLE `aktivitas_user` ADD COLUMN IF NOT EXISTS `olahraga` INT(11) NULL DEFAULT NULL",
    ];

    foreach ($queries as $query) {
        echo "Running: $query\n";
        $pdo->exec($query);
        echo "✓ Success\n";
    }

    echo "\n✅ Database schema updated successfully!\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
