# 🧪 TESTING & TROUBLESHOOTING GUIDE

## ✅ TESTING CHECKLIST

### **PHASE 1: Data Input Testing**

#### Test 1.1 - BMI Input
```
Steps:
1. Login ke aplikasi
2. Go to "Indeks Massa Tubuh"
3. Input:
   - Berat Badan: 70 kg
   - Tinggi Badan: 175 cm
4. Click "Hitung & Simpan"

Expected Results:
✅ Redirect ke BMI page dengan alert success
✅ Data tersimpan di database (aktivitas_user table)
✅ Cache cleared (laporan_*, stats_*)
✅ Next access to laporan akan show data baru
```

#### Test 1.2 - Tidur Input
```
Steps:
1. Go to "Pelacak Tidur"
2. Input:
   - Durasi: 7 jam
   - Kualitas: 8
3. Click "Simpan"

Expected Results:
✅ Data tersimpan di tidur_user table
✅ Cache cleared
✅ Laporan akan show:
   - Tidur Hari Ini: 7 jam
   - Status: ✅ Berkualitas (>= 7)
```

#### Test 1.3 - Makanan Input
```
Steps:
1. Go to "Pelacak Nutrisi"
2. Select: Nasi Goreng (300 kkal)
3. Porsi: 1
4. Click "Tambah"

Expected Results:
✅ Data tersimpan di makanan_user table
✅ total_kalori = 300 kkal (3 porsi kalori default)
✅ Laporan akan update kalori hari ini
```

### **PHASE 2: Laporan Data Verification**

#### Test 2.1 - Single Day Data
```
Scenario:
- Input 1x Berat: 70 kg
- Input 1x Tidur: 7 jam
- Input 1x Makanan: Nasi Goreng 1 porsi (300 kkal)

Expected in Laporan:
✅ Berat Hari Ini: 70 kg
✅ Tidur Hari Ini: 7 jam
✅ Kalori Hari Ini: 300 kkal
✅ Olahraga Hari Ini: 0 menit (jika tidak ada input)
```

#### Test 2.2 - Multiple Days Data (30-day periode)
```
Scenario:
- Input data setiap hari selama 7 hari
- Metrics: BMI, Tidur, Makanan

Expected Calculations:
✅ Berat Rata-rata = (berat_hari_1 + ... + berat_hari_7) / 7
✅ Tidur Rata-rata = (tidur_1 + ... + tidur_7) / 7
✅ Kalori Rata-rata = (total_kalori_semua) / 7
✅ Berat Perubahan = ((berat_hari_7 - berat_hari_1) / berat_hari_1) * 100
```

#### Test 2.3 - IMT Calculation
```
Formula: IMT = berat_badan (kg) / (tinggi_badan (m))^2

Examples:
- Input: 70 kg, 175 cm → IMT = 70 / (1.75)^2 = 22.86 → NORMAL ✅
- Input: 85 kg, 175 cm → IMT = 85 / (1.75)^2 = 27.75 → OVERWEIGHT ⚠️
- Input: 60 kg, 175 cm → IMT = 60 / (1.75)^2 = 19.59 → NORMAL ✅
- Input: 95 kg, 175 cm → IMT = 95 / (1.75)^2 = 31.02 → OBESE ❌

Expected Display:
✅ Category Badge dengan warna (green/yellow/red)
✅ Saran Berat Ideal
```

#### Test 2.4 - Kalori Target Calculation
```
Formula (WHO Standards):
Kalori Target = (Berat Ideal × 20) + 500 untuk deficit 500 kkal

Example:
- BMI Normal: Kalori = Berat Ideal × 20
- Kondisi: 70 kg, usia 25, sedentary
- Target ≈ 1600-1800 kkal

Expected in Laporan:
✅ Kalori Target Display
✅ Persentase Terpenuhi: (kalori_input / kalori_target) × 100
✅ Progress Bar mencapai 100% atau lebih
```

### **PHASE 3: Cache Testing**

#### Test 3.1 - Cache Clear on BMI Input
```
Flow:
1. Access Laporan Kesehatan → Note Berat Hari Ini = 70 kg
2. Go to BMI → Input 75 kg
3. Click Hitung & Simpan
4. Back to Laporan Kesehatan

Expected:
✅ Berat Hari Ini NOW = 75 kg (not 70 kg)
✅ Cache was cleared successfully
```

#### Test 3.2 - Cache Clear on Tidur Input
```
Flow:
1. Access Laporan → Note Tidur Hari Ini = 0 jam
2. Go to Tidur → Input 6 jam
3. Back to Laporan

Expected:
✅ Tidur Hari Ini NOW = 6 jam
✅ Status Badge = ⚠️ Cukup (6 hours)
```

#### Test 3.3 - Force Cache Clear
```
Scenario:
- Open Laporan 1000x times
- Data should always fresh

Check in Code (LaporanController):
Cache::forget('laporan_' . $user->id);
Cache::forget('stats_' . $user->id);

Result:
✅ Data ALWAYS fresh, no stale cache
```

### **PHASE 4: Rekomendasi Testing**

#### Test 4.1 - Tidur Warning
```
Condition: tidur_periode_avg < 6 jam
Input: 3 hari × 5 jam tidur

Expected Rekomendasi:
⚠️ "Istirahat Kurang - Tingkatkan durasi tidur minimal 7 jam setiap hari"
```

#### Test 4.2 - Olahraga Warning
```
Condition: olahraga_periode_total < 150 menit/minggu
Input: 1 hari × 30 menit olahraga saja

Expected Rekomendasi:
⚠️ "Aktivitas Fisik Kurang - Target WHO: 150 menit/minggu"
```

#### Test 4.3 - Kalori Excess Info
```
Condition: kalori_persen > 120%
Input: Kalori Target 2000, Input 2500+ kalori

Expected Rekomendasi:
ℹ️ "Kalori Berlebih - Monitor asupan kalori harian"
```

#### Test 4.4 - IMT Warning
```
Condition: imt > 25 (overweight)
Input: 85 kg, 175 cm (IMT 27.75)

Expected Rekomendasi:
⚠️ "IMT Tinggi - Tingkatkan aktivitas dan kontrol kalori"
```

#### Test 4.5 - Success Message
```
Condition: Semua metrics OK
- Tidur >= 7 jam
- Olahraga >= 150 menit/minggu
- Kalori ideal
- IMT normal

Expected Rekomendasi:
✅ "Gaya Hidup Sehat! - Teruskan pola hidup sehat ini"
```

---

## 🐛 TROUBLESHOOTING

### **Issue 1: Laporan Kesehatan Shows 404**

```
Symptoms:
- Page tidak load
- Error: "Route not found"

Diagnosis Steps:
1. Check route in routes/web.php:
   Route::get('/laporan/kesehatan', [LaporanController::class, 'kesehatan']);

2. Check middleware:
   Must have 'auth' middleware

3. Check controller exists:
   app/Http/Controllers/LaporanController.php

Solutions:
✅ If route missing → Add route
✅ If middleware wrong → Add 'auth'
✅ If controller missing → Create controller

Quick Fix:
php artisan route:list | grep laporan
```

### **Issue 2: Data Not Updating in Laporan**

```
Symptoms:
- Update BMI, tapi Laporan masih show data lama
- Update Tidur, tidak berubah di Laporan

Root Causes:
1. Cache tidak dihapus
2. Data tidak tersimpan di database
3. Wrong periode di request

Diagnosis:
1. Check logs: storage/logs/laravel.log
2. Check database: SELECT * FROM aktivitas_user WHERE user_id = X
3. Check cache: Check if Cache::forget() called

Solutions:
✅ Add Cache::forget() di controller:
   Cache::forget('laporan_' . $user->id);
   Cache::forget('stats_' . $user->id);

✅ Verify save di database:
   $data = AktivitasUser::where('user_id', $user->id)
               ->where('tanggal', today())
               ->first();
   dd($data); // check exists

✅ Check periode parameter:
   $periode = $request->get('periode', 30); // default 30 days
```

### **Issue 3: Metrics Calculating Wrong**

```
Symptoms:
- Berat rata-rata tidak sesuai
- Kalori tidak match
- IMT calculation error

Diagnosis Tools:
1. Add debug output di hitungStatistik():
   Log::info('Aktivitas data:', $aktivitasData->toArray());
   Log::info('Stats calculated:', $stats);

2. Manual calculation:
   Check values in database
   Calculate manually
   Compare with displayed value

Solutions:
✅ Check formula di hitungStatistik()
✅ Check query: is data filtered correctly?
✅ Check makanan relation: is with('makanan') used?

Example Debug:
// In LaporanController
$aktivitasData = AktivitasUser::where('user_id', $user->id)
    ->whereBetween('tanggal', [$dari, $sampai])
    ->get();

Log::info('Aktivitas count: ' . $aktivitasData->count());
Log::info('Data: ' . json_encode($aktivitasData));
```

### **Issue 4: Rekomendasi Not Showing**

```
Symptoms:
- Rekomendasi section kosong
- No suggestions displayed

Diagnosis:
1. Check if buatRekomendasi() called
2. Check if $rekomendasi passed to view
3. Check view loop

Solutions:
✅ Verify in kesehatan():
   $rekomendasi = $this->buatRekomendasi($stats);
   return view('laporan.kesehatan-baru', compact(..., 'rekomendasi'));

✅ Verify in view:
   @forelse($rekomendasi as $item)
       <!-- display -->
   @empty
       No recommendations
   @endforelse

✅ Check metrics for warnings:
   dd($stats); // check values
   dd($rekomendasi); // check output
```

### **Issue 5: PDF Not Downloading**

```
Symptoms:
- Click download PDF
- Nothing happens

Diagnosis:
1. Check route: routes/web.php
2. Check controller method
3. Check view template

Solutions:
✅ Add route:
   Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf']);

✅ Check controller:
   public function exportPdf() { ... }

✅ Check template exists:
   resources/views/laporan/pdf.blade.php
```

### **Issue 6: Email Not Sending**

```
Symptoms:
- Password reset requested
- Email tidak terima

Root Causes:
1. .env MAIL config wrong
2. PasswordResetMail missing 'to:' field
3. MAIL_DRIVER wrong

Diagnosis:
Check storage/logs/laravel.log for:
- "An email must have a To header"
- SMTP connection errors
- Mailer configuration errors

Solutions:
✅ Check .env:
   MAIL_MAILER=log (atau smtp)
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password (Google)
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com

✅ Check PasswordResetMail.php:
   public function envelope(): Envelope
   {
       return new Envelope(
           to: $this->user->email,  // ← MUST HAVE THIS
           subject: 'FitPlus - Reset Password',
       );
   }

✅ Test email:
   Use 'log' driver first (file-based)
   Check: storage/logs/laravel.log
   Then switch to 'smtp' with real credentials
```

---

## 🔍 DEBUG CHECKLIST

```
For any issue, check in order:

1. ✅ ROUTES
   php artisan route:list | grep laporan

2. ✅ LOGS
   tail -f storage/logs/laravel.log

3. ✅ DATABASE
   SELECT * FROM aktivitas_user/tidur_user/makanan_user

4. ✅ CACHE
   Check if Cache::forget() being called

5. ✅ MIDDLEWARE
   Check if user authenticated

6. ✅ VIEW
   Check if variables passed correctly

7. ✅ BROWSER CONSOLE
   Check for JavaScript errors

8. ✅ NETWORK TAB
   Check API responses (if using AJAX)

9. ✅ CODE REVIEW
   Check latest changes in controllers
   Check migrations are up-to-date
```

---

## 📊 TEST DATA SAMPLES

### **Sample Test Data - CSV Format**

```csv
tanggal,berat_badan,tinggi_badan,olahraga_menit,tidur_jam,tidur_kualitas,makanan_nama,porsi,kalori
2024-01-15,70,175,30,6,6,Nasi Goreng,1,300
2024-01-16,70.2,175,45,7,8,Nasi Goreng,1,300
2024-01-16,70.2,175,45,7,8,Sayuran,2,80
2024-01-17,69.8,175,60,8,9,Nasi Putih,1.5,200
2024-01-17,69.8,175,60,8,9,Ayam Goreng,1,250
2024-01-18,70,175,20,5,4,Burger,1,500
2024-01-19,70.5,175,90,7,7,Nasi Goreng,1,300
2024-01-20,70.1,175,40,8,8,Nasi Kuning,1,280
```

---

**SEMUA TESTING & TROUBLESHOOTING COVERED! ✅**
