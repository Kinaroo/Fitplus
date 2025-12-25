# 🚀 FITPLUS - QUICK START GUIDE

## Langkah 1: Jalankan Aplikasi

```bash
cd c:\Users\ASUS\Documents\Fitplus-main
php artisan serve
```

Aplikasi akan running di: **http://localhost:8000**

---

## Langkah 2: Login

**Email:** test@example.com  
**Password:** password

---

## Langkah 3: Mulai Gunakan Fitur

### A. Tambah Data Kesehatan
Menu: **Data Kesehatan**
1. Isi tanggal, umur, berat, tinggi, tidur, olahraga
2. Klik "Simpan"
3. ✅ Data **otomatis tersimpan** dan **otomatis update** Dashboard

### B. Tambah Data Tidur
Menu: **Pelacak Tidur**
1. Isi durasi tidur (jam)
2. Klik "Simpan"
3. ✅ Data **otomatis tersimpan** dan **otomatis update** analisis tidur

### C. Tambah Makanan
Menu: **Pelacak Nutrisi**
1. Pilih makanan dari daftar
2. Isi porsi
3. Klik "Tambah"
4. ✅ Kalori **otomatis dihitung** dan **otomatis tersimpan**

### D. Lihat Dashboard
Menu: **Dashboard**
- ✅ Semua data **otomatis ditampilkan**
- ✅ Statistik **otomatis dihitung**
- ✅ Status kesehatan **otomatis ditentukan**

### E. Lihat Laporan Kesehatan
Menu: **Laporan Kesehatan**
- ✅ Semua data **otomatis dimuat**
- ✅ Grafik **otomatis generate**
- ✅ Kalkulasi IMT **otomatis**
- ✅ Rekomendasi **otomatis dibuat**

---

## 🎯 Fitur-Fitur Utama

| Fitur | Status | Otomatis? |
|-------|--------|-----------|
| Aktivitas (Berat, Olahraga) | ✅ | Otomatis |
| Tidur | ✅ | Otomatis |
| Makanan & Kalori | ✅ | Otomatis |
| Dashboard | ✅ | Otomatis |
| Laporan Kesehatan | ✅ | Otomatis |
| Kalkulasi IMT | ✅ | Otomatis |
| Grafik/Chart | ✅ | Otomatis |
| Rekomendasi | ✅ | Otomatis |

---

## 🔄 Cara Kerja Auto-Sync

```
User Input Data
        ↓
Controller Validasi
        ↓
Database Save
        ↓
Cache Clear
        ↓
Dashboard/Laporan Auto-Update
```

**Hasilnya:** Tidak perlu refresh atau submit dua kali!

---

## 📊 Data Flow

```
Tambah Aktivitas
    ↓
Simpan ke aktivitas_user
    ↓
Dashboard auto-hitung rata-rata berat & olahraga
    ↓
Laporan auto-display statistik
```

```
Tambah Tidur
    ↓
Simpan ke tidur_user
    ↓
Dashboard auto-hitung rata-rata tidur
    ↓
Laporan auto-display tidur analysis
```

```
Tambah Makanan
    ↓
Auto-hitung kalori (kalori × porsi)
    ↓
Simpan ke makanan_user
    ↓
Dashboard auto-hitung total kalori
    ↓
Laporan auto-compare dengan target
```

---

## 🧪 Verifikasi Sistem (Opsional)

Untuk memastikan semua berjalan sempurna, jalankan:

```bash
php test-system-comprehensive.php
```

Harus semua ✓ (hijau).

---

## ⚠️ Jika Ada Masalah

### 1. Data tidak muncul di dashboard

```bash
php artisan cache:clear
php artisan view:clear
```

Lalu refresh browser (Ctrl+F5).

### 2. Error 500

Cek file: `storage/logs/laravel.log`

### 3. Database error

Jalankan ulang:
```bash
php artisan migrate:fresh --seed
```

---

## 💡 Tips & Trik

1. **Jangan perlu menyimpan data dua kali** - semua otomatis
2. **Jangan perlu refresh halaman** - data otomatis update
3. **Jangan perlu hitung manual** - semua otomatis dihitung
4. **Data aman tersimpan** - langsung ke database

---

## 📈 Apa yang Bisa Dilacak

### Aktivitas
- Berat badan (kg)
- Durasi olahraga (menit)
- Tinggi badan (cm)

### Tidur
- Durasi tidur (jam)
- Kualitas tidur (rating)
- Fase tidur

### Nutrisi
- Makanan yang dimakan
- Jumlah porsi
- Total kalori (otomatis hitung)
- Protein, Karbo, Lemak

---

## 🎨 Dashboard Menampilkan

- Rata-rata berat badan
- Rata-rata tidur
- Total olahraga
- Total kalori hari ini
- Status kesehatan (hijau/kuning/merah)

---

## 📄 Laporan Menampilkan

- Statistik 30/7/90 hari
- Grafik berat badan
- Grafik tidur
- Grafik olahraga
- Kalkulasi IMT
- Nutrisi detail
- Riwayat makanan
- Rekomendasi kesehatan

---

## 🔐 Keamanan

- ✅ Password ter-encrypt
- ✅ Data hanya terlihat user sendiri
- ✅ Input divalidasi
- ✅ SQL injection protection

---

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Cek file log: `storage/logs/laravel.log`
2. Jalankan: `php test-system-comprehensive.php`
3. Jalankan: `php fix-database.php`

---

**Selamat menggunakan FITPLUS! 🎉**

*All features auto-synced and ready to use!*
