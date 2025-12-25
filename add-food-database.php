<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "═══════════════════════════════════════════════════════════════\n";
echo "🍽️  MENAMBAH DATA MAKANAN KE DATABASE\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Data makanan yang akan ditambahkan
$makananList = [
    // Nasi & Karbohidrat
    ['nama_makanan' => 'Nasi Putih', 'kalori' => 130, 'protein' => 2.7, 'karbohidrat' => 28, 'lemak' => 0.3],
    ['nama_makanan' => 'Nasi Merah', 'kalori' => 111, 'protein' => 2.6, 'karbohidrat' => 23, 'lemak' => 0.9],
    ['nama_makanan' => 'Roti Tawar', 'kalori' => 265, 'protein' => 8.7, 'karbohidrat' => 49, 'lemak' => 3.3],
    ['nama_makanan' => 'Pasta', 'kalori' => 131, 'protein' => 5, 'karbohidrat' => 25, 'lemak' => 1.1],
    ['nama_makanan' => 'Oatmeal', 'kalori' => 389, 'protein' => 17, 'karbohidrat' => 66, 'lemak' => 6.9],
    
    // Protein
    ['nama_makanan' => 'Ayam Goreng', 'kalori' => 320, 'protein' => 30, 'karbohidrat' => 0, 'lemak' => 21],
    ['nama_makanan' => 'Ayam Rebus', 'kalori' => 165, 'protein' => 31, 'karbohidrat' => 0, 'lemak' => 3.6],
    ['nama_makanan' => 'Daging Sapi', 'kalori' => 250, 'protein' => 26, 'karbohidrat' => 0, 'lemak' => 15],
    ['nama_makanan' => 'Ikan Salmon', 'kalori' => 208, 'protein' => 20, 'karbohidrat' => 0, 'lemak' => 13],
    ['nama_makanan' => 'Telur Goreng', 'kalori' => 155, 'protein' => 13, 'karbohidrat' => 1.1, 'lemak' => 11],
    ['nama_makanan' => 'Telur Rebus', 'kalori' => 155, 'protein' => 13, 'karbohidrat' => 1.1, 'lemak' => 11],
    ['nama_makanan' => 'Tahu', 'kalori' => 76, 'protein' => 8, 'karbohidrat' => 2, 'lemak' => 4.8],
    ['nama_makanan' => 'Tempe', 'kalori' => 192, 'protein' => 19, 'karbohidrat' => 9.3, 'lemak' => 10.8],
    
    // Sayuran
    ['nama_makanan' => 'Brokoli', 'kalori' => 34, 'protein' => 2.8, 'karbohidrat' => 7, 'lemak' => 0.4],
    ['nama_makanan' => 'Wortel', 'kalori' => 41, 'protein' => 0.9, 'karbohidrat' => 10, 'lemak' => 0.2],
    ['nama_makanan' => 'Bayam', 'kalori' => 23, 'protein' => 2.9, 'karbohidrat' => 4, 'lemak' => 0.4],
    ['nama_makanan' => 'Kubis', 'kalori' => 25, 'protein' => 1.3, 'karbohidrat' => 6, 'lemak' => 0.1],
    ['nama_makanan' => 'Tomat', 'kalori' => 18, 'protein' => 0.9, 'karbohidrat' => 3.9, 'lemak' => 0.2],
    
    // Buah
    ['nama_makanan' => 'Pisang', 'kalori' => 89, 'protein' => 1.1, 'karbohidrat' => 23, 'lemak' => 0.3],
    ['nama_makanan' => 'Apel', 'kalori' => 52, 'protein' => 0.3, 'karbohidrat' => 14, 'lemak' => 0.2],
    ['nama_makanan' => 'Jeruk', 'kalori' => 47, 'protein' => 0.7, 'karbohidrat' => 12, 'lemak' => 0.3],
    ['nama_makanan' => 'Strawberry', 'kalori' => 32, 'protein' => 0.7, 'karbohidrat' => 7.7, 'lemak' => 0.3],
    ['nama_makanan' => 'Mangga', 'kalori' => 60, 'protein' => 0.8, 'karbohidrat' => 15, 'lemak' => 0.4],
    
    // Produk Susu
    ['nama_makanan' => 'Susu Sapi', 'kalori' => 61, 'protein' => 3.2, 'karbohidrat' => 4.8, 'lemak' => 3.3],
    ['nama_makanan' => 'Yogurt', 'kalori' => 59, 'protein' => 10, 'karbohidrat' => 3.6, 'lemak' => 0.4],
    ['nama_makanan' => 'Keju', 'kalori' => 402, 'protein' => 25, 'karbohidrat' => 1.3, 'lemak' => 33],
    
    // Kacang & Biji
    ['nama_makanan' => 'Kacang Almond', 'kalori' => 579, 'protein' => 21, 'karbohidrat' => 22, 'lemak' => 50],
    ['nama_makanan' => 'Kacang Tanah', 'kalori' => 567, 'protein' => 26, 'karbohidrat' => 20, 'lemak' => 49],
    
    // Makanan Tradisional
    ['nama_makanan' => 'Gado-gado', 'kalori' => 150, 'protein' => 6, 'karbohidrat' => 20, 'lemak' => 6],
    ['nama_makanan' => 'Soto Ayam', 'kalori' => 120, 'protein' => 8, 'karbohidrat' => 12, 'lemak' => 4],
    ['nama_makanan' => 'Rendang', 'kalori' => 450, 'protein' => 25, 'karbohidrat' => 5, 'lemak' => 38],
    ['nama_makanan' => 'Lumpia', 'kalori' => 330, 'protein' => 8, 'karbohidrat' => 40, 'lemak' => 16],
    ['nama_makanan' => 'Perkedel', 'kalori' => 290, 'protein' => 4, 'karbohidrat' => 35, 'lemak' => 14],
    
    // Camilan
    ['nama_makanan' => 'Coklat', 'kalori' => 546, 'protein' => 4.9, 'karbohidrat' => 58, 'lemak' => 31],
    ['nama_makanan' => 'Chips', 'kalori' => 536, 'protein' => 7.8, 'karbohidrat' => 50, 'lemak' => 35],
    ['nama_makanan' => 'Kue Lapis', 'kalori' => 200, 'protein' => 2, 'karbohidrat' => 30, 'lemak' => 8],
    
    // Minuman
    ['nama_makanan' => 'Jus Jeruk', 'kalori' => 45, 'protein' => 0.7, 'karbohidrat' => 11, 'lemak' => 0.2],
    ['nama_makanan' => 'Kopi', 'kalori' => 2, 'protein' => 0.3, 'karbohidrat' => 0, 'lemak' => 0],
    ['nama_makanan' => 'Teh', 'kalori' => 1, 'protein' => 0, 'karbohidrat' => 0, 'lemak' => 0],
];

try {
    // Check current count
    $currentCount = DB::table('info_makanan')->count();
    echo "📊 Jumlah makanan saat ini: {$currentCount}\n\n";
    
    // Insert all food items
    foreach ($makananList as $makanan) {
        $exists = DB::table('info_makanan')
            ->where('nama_makanan', $makanan['nama_makanan'])
            ->exists();
        
        if (!$exists) {
            DB::table('info_makanan')->insert([
                'nama_makanan' => $makanan['nama_makanan'],
                'kalori' => $makanan['kalori'],
                'protein' => $makanan['protein'],
                'karbohidrat' => $makanan['karbohidrat'],
                'lemak' => $makanan['lemak'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "✅ " . $makanan['nama_makanan'] . " - {$makanan['kalori']} kkal\n";
        } else {
            echo "⏭️  " . $makanan['nama_makanan'] . " (sudah ada)\n";
        }
    }
    
    // Show final count
    $newCount = DB::table('info_makanan')->count();
    echo "\n═══════════════════════════════════════════════════════════════\n";
    echo "✅ SELESAI!\n";
    echo "📊 Total makanan sekarang: {$newCount}\n";
    echo "═══════════════════════════════════════════════════════════════\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
