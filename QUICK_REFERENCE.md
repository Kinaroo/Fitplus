# 🚀 QUICK START GUIDE - LAPORAN KESEHATAN

## Akses Cepat

### URL Langsung
```
http://localhost:8000/laporan/kesehatan
http://localhost:8000/laporan/kesehatan?periode=7
http://localhost:8000/laporan/kesehatan?periode=30
```

## Komponen Utama

### 1️⃣ Sidebar Navigation
```
• Dashboard
• Profil
• Pelacak Nutrisi
• Indeks Massa Tubuh
• Pelacak Tidur
• Tantangan Olahraga
• Laporan Kesehatan (ACTIVE)
• Keluar
```

### 2️⃣ Filter Periode
Button untuk memilih rentang waktu:
- **7 Hari** - Analisis mingguan
- **2 Minggu** - Analisis 2 minggu
- **30 Hari** - Analisis bulanan

### 3️⃣ Rekomendasi Section
Menampilkan 1-6 tips kesehatan berdasarkan kondisi:
```
✅ SUCCESS - Hijau (Gaya hidup sehat)
⚠️ WARNING - Amber/Merah (Ada masalah)
ℹ️ INFO - Biru (Informasi penting)
```

### 4️⃣ Stat Cards

#### Ringkasan Harian (4 cards)
```
📊 Berat Badan      →  Kg
😴 Jam Tidur        →  Jam
🔥 Olahraga        →  Menit
🍎 Kalori          →  kkal
```

#### Statistik Periode (4 cards)
```
📈 Rata-rata Berat    →  Kg
📊 Rata-rata Tidur    →  Jam
🔥 Total Olahraga     →  Menit
🍎 Total Kalori       →  kkal
```

### 5️⃣ Grafik (Charts)
Hanya tampil jika ada data:
```
📈 Berat Badan - Line Chart (Hijau)
📈 Jam Tidur - Line Chart (Teal)
📊 Olahraga - Bar Chart (Amber)
```

### 6️⃣ Action Buttons
```
← Kembali ke Dashboard
🖨️ Cetak Laporan
```

## Data Sources

### Database Tables

| Table | Fields | Purpose |
|-------|--------|---------|
| aktivitas_users | berat_badan, olahraga, tanggal | Tracking berat & olahraga |
| tidur_users | durasi_jam, tanggal | Tracking tidur |
| makanan_users | total_kalori, tanggal | Tracking kalori |
| users | tinggi, email, nama | User info |

### Query Logic
```php
// Untuk setiap periode:
$aktivitas = AktivitasUser::where('user_id', $userId)
    ->whereBetween('tanggal', [$startDate, $today])
    ->orderBy('tanggal', 'asc')
    ->get();

$tidur = TidurUser::where('user_id', $userId)
    ->whereBetween('tanggal', [$startDate, $today])
    ->get();

$makanan = MakananUser::where('user_id', $userId)
    ->whereBetween('tanggal', [$startDate, $today])
    ->get();
```

## Kalkulasi Utama

### Rata-rata Berat
```
= SUM(berat_badan) / COUNT(records)
```

### Rata-rata Tidur
```
= SUM(durasi_jam) / COUNT(records)
```

### Total Olahraga
```
= SUM(olahraga) dalam menit
```

### Persentase Kalori
```
= (total_kalori / target_kalori) * 100
```

### IMT (Indeks Massa Tubuh)
```
= berat / (tinggi/100)²
Kategori:
  < 18.5  = Kurus
  18.5-25 = Normal
  25-30   = Gemuk
  > 30    = Obesitas
```

## Rekomendasi Rules

### 1. Tidur
```
IF tidur_minggu_avg < 6 THEN
  → WARNING: Istirahat Kurang
  → Message: Tingkatkan durasi tidur
```

### 2. Olahraga
```
IF olahraga_minggu < 150 THEN
  → WARNING: Aktivitas Fisik Kurang
  → Message: Target WHO 150 menit/minggu
```

### 3. Kalori
```
IF kalori_hari > (target * 1.2) THEN
  → INFO: Kalori Berlebih
  → Message: Perhatikan porsi makanan
```

### 4. BMI
```
IF imt > 25 THEN
  → WARNING: IMT Tinggi
  → Message: Konsultasi ahli gizi
ELSEIF imt < 18.5 THEN
  → INFO: IMT Rendah
  → Message: Asupan nutrisi tepat
```

### 5. Motivasi
```
IF tidur_minggu >= 7 THEN
  → SUCCESS: Tidur Berkualitas
ELSEIF semua kondisi baik THEN
  → SUCCESS: Gaya Hidup Sehat
```

## Styling & Theme

### Warna Scheme
```css
Primary    #16a34a (Hijau Tua)
Secondary  #0d9488 (Teal)
Accent     #f59e0b (Amber)
Light      #f0fdf4 (Hijau Muda)
Dark       #1f2937 (Gray Gelap)
```

### Card Styling
```
- Border-left 5px (warna sesuai kategori)
- Border-radius 16px
- Shadow 0 2px 8px
- Hover: translateY(-5px)
```

### Alert Styling
```
Success: Gradient hijau + border hijau
Warning: Gradient amber + border amber
Info: Gradient biru + border biru
```

## Print/Cetak

Klik tombol "Cetak Laporan" atau Ctrl+P:
```
✓ Automatic page break untuk chart
✓ Sidebar tidak print
✓ Colors optimized untuk print
✓ Professional layout
```

## Troubleshooting

### Tidak Ada Data?
```
1. Pastikan user sudah login
2. Check database: SELECT * FROM aktivitas_users WHERE user_id = ?
3. Pastikan tanggal data valid
4. Jalankan seeder jika perlu
```

### Chart Tidak Muncul?
```
1. Check browser console (F12)
2. Pastikan Chart.js loaded
3. Pastikan data JSON valid
4. Clear browser cache
```

### Rekomendasi Tidak Muncul?
```
1. Check controller buatRekomendasi()
2. Verify data queries menghasilkan records
3. Check kondisi if statements
4. Log data untuk debugging
```

### Styling Tidak Muncul?
```
1. Pastikan Tailwind CDN loaded
2. Pastikan Font Awesome loaded
3. Check style tag di <head>
4. Clear CSS cache
```

## Performance Tips

### Optimasi Query
```php
// GOOD - Efficient
AktivitasUser::where('user_id', $userId)
    ->whereBetween('tanggal', [$start, $end])
    ->orderBy('tanggal', 'asc')
    ->get();

// BAD - Multiple queries
foreach($users as $user) {
    AktivitasUser::where('user_id', $user->id)->get();
}
```

### Caching (Optional)
```php
Cache::remember('laporan_' . $userId, 3600, function() {
    return $this->hitungStatistik(...);
});
```

## Browser Compatibility

| Browser | Support |
|---------|---------|
| Chrome | ✅ Full |
| Firefox | ✅ Full |
| Safari | ✅ Full |
| Edge | ✅ Full |
| IE 11 | ❌ Not supported |

## Mobile Responsiveness

```
Mobile (<768px)
├─ Sidebar collapses or hideable
├─ Grid 2 kolom
├─ Touch-friendly buttons
└─ Optimized font size

Tablet (768-1024px)
├─ Sidebar visible
├─ Grid 4 kolom
└─ Balanced layout

Desktop (>1024px)
├─ Full sidebar
├─ Grid 4 kolom optimal
└─ All features visible
```

## Security Notes

- ✅ Auth middleware aktif (hanya login user)
- ✅ User data isolated (user_id check)
- ✅ XSS protection ({{ }} escaping)
- ✅ CSRF token valid
- ✅ No sensitive data in logs

## Files Reference

```
app/Http/Controllers/LaporanController.php
  └─ kesehatan()
  └─ hitungStatistik()
  └─ buatChartData()
  └─ buatRekomendasi()

resources/views/laporan/kesehatan.blade.php
  └─ HTML Structure
  └─ Tailwind Classes
  └─ Inline Styles
  └─ Chart.js Script

routes/web.php
  └─ Route::get('/laporan/kesehatan', ...)
```

## Environment Variables (jika diperlukan)

```
APP_URL=http://localhost:8000
APP_DEBUG=true
DB_DATABASE=fitplus
```

---

**Version**: 2.0  
**Last Update**: December 11, 2025  
**Status**: ✅ Production Ready
