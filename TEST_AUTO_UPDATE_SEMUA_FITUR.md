# 🧪 TESTING AUTO-UPDATE SEMUA FITUR KE LAPORAN KESEHATAN

## 📋 Fitur yang Akan Ditest

1. ✅ **Indeks Masa Tubuh (BMI)** - Berat & Tinggi Badan
2. ✅ **Pelacak Tidur** - Durasi Tidur
3. ✅ **Pelacak Nutrisi** - Kalori & Nutrisi
4. ✅ **Aktivitas Olahraga** - Durasi Olahraga
5. ✅ **Tantangan Olahraga** - Target Tantangan

---

## 🔧 SETUP SEBELUM TEST

```bash
# 1. Clear cache
php artisan cache:clear
php artisan config:clear

# 2. Restart server
Ctrl + C
php artisan serve

# 3. Login ke FitPlus
http://localhost:8000/login
```

**User Login:**
- Email: `dzackydarqo@gmail.com`
- Password: `Dz@cky020405`

---

## ✅ TEST 1: INDEKS MASA TUBUH (BMI)

### Langkah-Langkah:

1. **Sidebar → Click "Indeks Masa Tubuh"**
   - URL: `http://localhost:8000/kalori/bmi`

2. **Input Data:**
   - Berat Badan: **75** kg
   - Tinggi Badan: **174** cm
   - Click **"Hitung"**

3. **Hasil yang Diharapkan:**
   ```
   ✅ Message: "BMI berhasil dihitung dan disimpan! Data akan langsung terupdate di Laporan Kesehatan."
   ✅ Tampil: BMI = 24.8 (Normal)
   ```

4. **Verifikasi Update di Database:**
   ```bash
   php artisan tinker
   > App\Models\AktivitasUser::where('user_id', 7)->latest()->first()
   
   # Output harus tampil:
   # berat_badan: 75
   # tinggi_badan: 174
   # tanggal: 2025-12-12
   ```

5. **Cek di Laporan Kesehatan:**
   - Click **"Laporan Kesehatan"** di sidebar
   - Cari section **"Berat Badan Rata-rata"**
   - **HARUS TAMPIL: 75 kg** ✅

6. **Test Update Lagi:**
   - Kembali ke **Indeks Masa Tubuh**
   - Ubah Berat: **76** kg
   - Click **"Hitung"**
   - Kembali ke **Laporan Kesehatan**
   - **HARUS UPDATE ke 76 kg** ✅

---

## ✅ TEST 2: PELACAK TIDUR

### Langkah-Langkah:

1. **Sidebar → Click "Pelacak Tidur"**
   - URL: `http://localhost:8000/tidur/analisis`

2. **Input Data Tidur (cari form di page):**
   - Durasi Tidur: **7.5** jam
   - Kualitas Tidur: **8/10** (jika ada)
   - Click **"Simpan"** atau **"Tambah Data"**

3. **Hasil yang Diharapkan:**
   ```
   ✅ Message: "Data tidur tersimpan dan akan terupdate di Laporan Kesehatan"
   ```

4. **Verifikasi Update di Database:**
   ```bash
   php artisan tinker
   > App\Models\TidurUser::where('user_id', 7)->latest()->first()
   
   # Output harus tampil:
   # durasi_jam: 7.5
   # tanggal: 2025-12-12
   ```

5. **Cek di Laporan Kesehatan:**
   - Click **"Laporan Kesehatan"**
   - Cari section **"Tidur Rata-rata"**
   - **HARUS TAMPIL: 7.5 jam** ✅

6. **Test Update Lagi:**
   - Kembali ke **Pelacak Tidur**
   - Ubah Durasi: **8** jam
   - Click **"Simpan"**
   - Kembali ke **Laporan Kesehatan**
   - **HARUS UPDATE ke 8 jam** ✅

---

## ✅ TEST 3: PELACAK NUTRISI (MAKANAN)

### Langkah-Langkah:

1. **Sidebar → Click "Pelacak Nutrisi"**
   - URL: `http://localhost:8000/makanan/harian`

2. **Input Data Makanan:**
   - Click **"Tambah Makanan"** atau **"+ Tambah"**
   - Pilih Makanan: **Nasi (200g)** atau makanan apapun
   - Porsi: **1**
   - Click **"Tambah"**

3. **Hasil yang Diharapkan:**
   ```
   ✅ Message: "Makanan berhasil ditambahkan dan akan terupdate di Laporan Kesehatan!"
   ```

4. **Verifikasi Update di Database:**
   ```bash
   php artisan tinker
   > App\Models\MakananUser::where('user_id', 7)->latest()->first()
   
   # Output harus tampil:
   # makanan_id: [id makanan]
   # porsi: 1
   # total_kalori: [jumlah kalori]
   # tanggal: 2025-12-12
   ```

5. **Cek di Laporan Kesehatan:**
   - Click **"Laporan Kesehatan"**
   - Cari section **"Kalori Hari Ini"** atau **"Kalori Periode"**
   - **HARUS TAMPIL total kalori dari makanan yang ditambah** ✅

6. **Test Update Lagi:**
   - Kembali ke **Pelacak Nutrisi**
   - Tambah makanan lain: **Ayam Goreng (150g)**
   - Kembali ke **Laporan Kesehatan**
   - **Kalori HARUS bertambah** ✅

---

## ✅ TEST 4: AKTIVITAS OLAHRAGA

### Langkah-Langkah:

1. **Sidebar → Click "Dashboard"**
   - URL: `http://localhost:8000/dashboard`

2. **Cari Section "Tambah Data Kesehatan Harian"** (biasanya di bawah dashboard)
   - Atau direct URL: `http://localhost:8000/health-data/form`

3. **Input Data Olahraga:**
   - Berat Badan: **75** kg
   - Tinggi Badan: **174** cm
   - Durasi Tidur: **7** jam
   - Durasi Olahraga: **60** menit
   - Click **"Simpan"**

4. **Hasil yang Diharapkan:**
   ```
   ✅ Message: "Data kesehatan berhasil ditambahkan dan akan terupdate di Laporan Kesehatan!"
   ```

5. **Verifikasi Update di Database:**
   ```bash
   php artisan tinker
   > App\Models\AktivitasUser::where('user_id', 7)->latest()->first()
   
   # Output harus tampil:
   # olahraga: 60
   # berat_badan: 75
   # tanggal: 2025-12-12
   ```

6. **Cek di Laporan Kesehatan:**
   - Click **"Laporan Kesehatan"**
   - Cari section **"Olahraga Rata-rata"** atau **"Total Olahraga"**
   - **HARUS TAMPIL: 60 menit** ✅

7. **Test Update Lagi:**
   - Kembali ke Dashboard
   - Input lagi dengan durasi olahraga: **90** menit
   - Kembali ke **Laporan Kesehatan**
   - **Total olahraga HARUS bertambah** ✅

---

## ✅ TEST 5: TANTANGAN OLAHRAGA

### Langkah-Langkah:

1. **Sidebar → Click "Tantangan Olahraga"**
   - URL: `http://localhost:8000/tantangan/progres`

2. **Buat Tantangan Baru:**
   - Click **"Buat Tantangan"** atau **"+ Tantangan Baru"**
   - Nama Tantangan: **"Olahraga Pagi"**
   - Target Harian: **30** menit
   - Durasi: **7** hari
   - Click **"Buat"**

3. **Hasil yang Diharapkan:**
   ```
   ✅ Message: "Tantangan berhasil dibuat dan akan terupdate di Laporan Kesehatan!"
   ```

4. **Verifikasi Update di Database:**
   ```bash
   php artisan tinker
   > App\Models\TantanganUser::where('user_id', 7)->latest()->first()
   
   # Output harus tampil:
   # nama_tantangan: "Olahraga Pagi"
   # status: "proses"
   # user_id: 7
   ```

5. **Cek di Laporan Kesehatan:**
   - Click **"Laporan Kesehatan"**
   - Scroll ke bawah cari **"Rekomendasi"** atau **"Tantangan Aktif"**
   - **HARUS TAMPIL info tantangan yang dibuat** ✅

---

## 🎯 CHECKLIST LENGKAP

### Sebelum Testing:
- [ ] Server running (`php artisan serve`)
- [ ] Cache sudah clear (`php artisan cache:clear`)
- [ ] Login ke FitPlus
- [ ] Akses Laporan Kesehatan pertama kali

### Testing BMI:
- [ ] Input berat 75 kg, tinggi 174 cm
- [ ] Lihat success message
- [ ] Laporan tampil berat 75 kg
- [ ] Update berat ke 76 kg
- [ ] Laporan update ke 76 kg ✅

### Testing Tidur:
- [ ] Input durasi tidur 7.5 jam
- [ ] Lihat success message
- [ ] Laporan tampil tidur 7.5 jam
- [ ] Update durasi ke 8 jam
- [ ] Laporan update ke 8 jam ✅

### Testing Makanan:
- [ ] Tambah makanan (nasi, ayam, dll)
- [ ] Lihat success message
- [ ] Laporan tampil total kalori
- [ ] Tambah makanan lagi
- [ ] Laporan update total kalori ✅

### Testing Olahraga:
- [ ] Input durasi olahraga 60 menit
- [ ] Lihat success message
- [ ] Laporan tampil olahraga 60 menit
- [ ] Input olahraga lagi 90 menit
- [ ] Laporan update total olahraga ✅

### Testing Tantangan:
- [ ] Buat tantangan baru
- [ ] Lihat success message
- [ ] Laporan tampil info tantangan
- [ ] Update/edit tantangan
- [ ] Laporan update ✅

---

## 🔍 VERIFIKASI CACHE CLEAR (TECHNICAL)

Setiap kali data disimpan, cache harus clear. Check di code:

```bash
php artisan tinker

# 1. Check cache keys sebelum update
> Cache::getStore()->getAll()

# 2. Input data di salah satu fitur
# (buka browser, masukkan data)

# 3. Check cache keys sesudah update
> Cache::getStore()->getAll()

# Seharusnya key 'laporan_7' dan 'stats_7' hilang ✅
```

---

## ❌ TROUBLESHOOTING

### Jika Data TIDAK Update di Laporan:

**1. Check Database Direct:**
```bash
mysql -u root fitplus

SELECT * FROM aktivitas_user WHERE user_id = 7 ORDER BY tanggal DESC LIMIT 1;
SELECT * FROM tidur_user WHERE user_id = 7 ORDER BY tanggal DESC LIMIT 1;
SELECT * FROM makanan_user WHERE user_id = 7 ORDER BY tanggal DESC LIMIT 1;

# Kalau data ada di database tapi tidak tampil di laporan = caching issue
# Kalau data TIDAK ada = save gagal
```

**2. Clear Cache Lebih Agresif:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:cache --force

# Restart server
Ctrl + C
php artisan serve
```

**3. Check Logs:**
```bash
tail -f storage/logs/laravel.log | grep -i "laporan\|cache\|forget"

# Cari log yang menunjukkan cache clear berhasil
# Output harus ada: "Laporan kesehatan accessed" dan cache forget message
```

**4. Direct Query dari Laporan Page:**
```bash
php artisan tinker

# Test hitungStatistik function
> $user = App\Models\User::find(7);
> $aktivitas = App\Models\AktivitasUser::where('user_id', 7)
  ->whereDate('tanggal', now()->toDateString())
  ->first();
> $aktivitas->berat_badan

# Harus return nilai terbaru yang baru disimpan
```

---

## 📊 HASIL AKHIR EXPECTED

Setelah semua test selesai, **Laporan Kesehatan harus menampilkan:**

```
┌─────────────────────────────────┐
│   LAPORAN KESEHATAN BERKALA     │
├─────────────────────────────────┤
│ Berat Badan Rata-rata: 75 kg    │ ← dari BMI
│ Tidur Rata-rata: 8 jam          │ ← dari Pelacak Tidur
│ Olahraga Rata-rata: 75 menit    │ ← dari Aktivitas
│ Kalori Hari Ini: 2500 kkal      │ ← dari Makanan
│                                  │
│ REKOMENDASI:                     │
│ ✅ Tidur Berkualitas (8 jam)     │ ← auto generated
│ ⚠️ Aktivitas Fisik Cukup         │ ← auto generated
│ ✅ Gaya Hidup Sehat!             │ ← auto generated
└─────────────────────────────────┘
```

**SEMUA DATA FRESH & AUTO-UPDATE!** 🎉

---

## 📞 QUICK REFERENCE URLS

| Fitur | URL |
|-------|-----|
| Dashboard | `http://localhost:8000/dashboard` |
| BMI | `http://localhost:8000/kalori/bmi` |
| Tidur | `http://localhost:8000/tidur/analisis` |
| Makanan | `http://localhost:8000/makanan/harian` |
| Olahraga | `http://localhost:8000/health-data/form` |
| Tantangan | `http://localhost:8000/tantangan/progres` |
| **Laporan** | **`http://localhost:8000/laporan/kesehatan`** |

---

**Status: READY TO TEST** ✅

Mari test semua fitur dan konfirmkan semuanya auto-update!
