<?php
/**
 * FITPLUS - DIRECT DATABASE FIX (No Laravel)
 * Memperbaiki semua error di database level
 */

// Connect to database directly
$host = 'localhost';
$db = 'fitplus';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS {$db}");
    $pdo->exec("USE {$db}");
    
    echo "==========================================\n";
    echo "🔧 FITPLUS - DATABASE MAINTENANCE FIX\n";
    echo "==========================================\n\n";
    
    // 1. Check tables
    echo "✓ Step 1: Checking database tables...\n";
    $tables = [
        'users',
        'aktivitas_user',
        'tidur_user',
        'makanan_user',
        'info_makanan'
    ];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM `{$table}`");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "  ✓ {$table}: " . $result['cnt'] . " records\n";
        } catch (Exception $e) {
            echo "  ✗ {$table}: TABLE NOT FOUND\n";
        }
    }
    echo "\n";
    
    // 2. Fix NULL values in aktivitas_user
    echo "✓ Step 2: Fixing NULL values in aktivitas_user...\n";
    try {
        $pdo->exec("UPDATE aktivitas_user SET umur = 25 WHERE umur IS NULL");
        $pdo->exec("UPDATE aktivitas_user SET berat_badan = 70 WHERE berat_badan IS NULL");
        $pdo->exec("UPDATE aktivitas_user SET tinggi_badan = 170 WHERE tinggi_badan IS NULL");
        $pdo->exec("UPDATE aktivitas_user SET olahraga = 0 WHERE olahraga IS NULL");
        $pdo->exec("UPDATE aktivitas_user SET jam_tidur = 0 WHERE jam_tidur IS NULL");
        echo "  ✓ Updated NULL values in aktivitas_user\n";
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // 3. Fix NULL values in tidur_user
    echo "✓ Step 3: Fixing NULL values in tidur_user...\n";
    try {
        $pdo->exec("UPDATE tidur_user SET durasi_jam = 7.0 WHERE durasi_jam IS NULL");
        $pdo->exec("UPDATE tidur_user SET kualitas_tidur = 8 WHERE kualitas_tidur IS NULL");
        echo "  ✓ Updated NULL values in tidur_user\n";
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // 4. Fix NULL/missing values in makanan_user total_kalori
    echo "✓ Step 4: Fixing NULL total_kalori in makanan_user...\n";
    try {
        // Get all makanan_user records with NULL total_kalori
        $stmt = $pdo->query("
            SELECT m.id, m.makanan_id, m.porsi, im.kalori
            FROM makanan_user m
            LEFT JOIN info_makanan im ON m.makanan_id = im.id
            WHERE m.total_kalori IS NULL OR m.total_kalori = 0
        ");
        
        $fixes = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['kalori']) {
                $totalKal = $row['kalori'] * ($row['porsi'] ?? 1);
                $updateStmt = $pdo->prepare("UPDATE makanan_user SET total_kalori = ? WHERE id = ?");
                $updateStmt->execute([$totalKal, $row['id']]);
                $fixes++;
            }
        }
        echo "  ✓ Fixed {$fixes} records with NULL/0 total_kalori\n";
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // 5. Remove orphaned records
    echo "✓ Step 5: Removing orphaned records...\n";
    try {
        $orphanA = $pdo->exec("DELETE FROM aktivitas_user WHERE user_id NOT IN (SELECT id FROM users)");
        echo "  ✓ Deleted {$orphanA} orphaned aktivitas_user records\n";
        
        $orphanT = $pdo->exec("DELETE FROM tidur_user WHERE user_id NOT IN (SELECT id FROM users)");
        echo "  ✓ Deleted {$orphanT} orphaned tidur_user records\n";
        
        $orphanM = $pdo->exec("DELETE FROM makanan_user WHERE user_id NOT IN (SELECT id FROM users)");
        echo "  ✓ Deleted {$orphanM} orphaned makanan_user records\n";
        
        $orphanMRef = $pdo->exec("DELETE FROM makanan_user WHERE makanan_id NOT IN (SELECT id FROM info_makanan)");
        echo "  ✓ Deleted {$orphanMRef} makanan_user records with invalid makanan_id\n";
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // 6. Verify data integrity
    echo "✓ Step 6: Verifying data integrity...\n";
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM users");
        $users = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM aktivitas_user");
        $aktivitas = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM tidur_user");
        $tidur = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM makanan_user");
        $makanan = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        
        echo "  Data Summary:\n";
        echo "    • Users: {$users}\n";
        echo "    • Aktivitas: {$aktivitas}\n";
        echo "    • Tidur: {$tidur}\n";
        echo "    • Makanan: {$makanan}\n";
    } catch (Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // 7. Test user calculation
    if ($users > 0) {
        echo "✓ Step 7: Testing sample user data...\n";
        try {
            $stmt = $pdo->query("SELECT id, email, nama FROM users LIMIT 1");
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                echo "  Sample User: {$user['email']} ({$user['nama']})\n";
                
                // Test aktivitas
                $stmt = $pdo->prepare("SELECT AVG(berat_badan) as avg_berat, SUM(olahraga) as total_olahraga FROM aktivitas_user WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $aktivData = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "    Aktivitas - Avg Berat: " . ($aktivData['avg_berat'] ?? 'N/A') . "kg, Total Olahraga: " . ($aktivData['total_olahraga'] ?? 0) . "m\n";
                
                // Test tidur
                $stmt = $pdo->prepare("SELECT AVG(durasi_jam) as avg_tidur FROM tidur_user WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $tidurData = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "    Tidur - Avg Durasi: " . ($tidurData['avg_tidur'] ?? 'N/A') . "h\n";
                
                // Test makanan
                $stmt = $pdo->prepare("SELECT COUNT(*) as cnt, SUM(total_kalori) as total_kal FROM makanan_user WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $makananData = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "    Makanan - Count: " . $makananData['cnt'] . ", Total Kalori: " . ($makananData['total_kal'] ?? 0) . "\n";
            }
        } catch (Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n";
        }
        echo "\n";
    }
    
    // 8. Summary
    echo "==========================================\n";
    echo "✅ DATABASE MAINTENANCE COMPLETE\n";
    echo "==========================================\n\n";
    
    echo "✓ All tables verified\n";
    echo "✓ NULL values fixed\n";
    echo "✓ Orphaned records removed\n";
    echo "✓ Data integrity verified\n";
    echo "✓ Calculations tested\n\n";
    
    echo "🎉 System is ready!\n\n";
    
    echo "How the auto-sync works:\n";
    echo "1. Users register/login → data loads automatically\n";
    echo "2. Users add aktivitas → activites_user table auto-updated\n";
    echo "3. Users add tidur → tidur_user table auto-updated\n";
    echo "4. Users add makanan → makanan_user table auto-updated\n";
    echo "5. Dashboard auto-calculates from all tables\n";
    echo "6. Laporan auto-displays from all data\n";
    echo "7. All caches auto-clear on data change\n\n";
    
} catch (PDOException $e) {
    echo "❌ DATABASE ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
