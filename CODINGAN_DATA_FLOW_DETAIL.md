# 📊 LAPORAN KESEHATAN - DATA FLOW & INTEGRATION

## 🔄 DATA FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────────────────────┐
│                         USER DASHBOARD                              │
├─────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  Sidebar Menu:                                                       │
│  ├─ Dashboard                                                       │
│  ├─ Pelacak Nutrisi → Input Makanan                                │
│  ├─ Indeks Massa Tubuh → Input Berat/Tinggi                        │
│  ├─ Pelacak Tidur → Input Durasi Tidur                             │
│  ├─ Tantangan Olahraga → Input Olahraga                            │
│  └─ Laporan Kesehatan ← ⭐ MAIN REPORT                             │
│                                                                      │
└─────────────────────────────────────────────────────────────────────┘
                                  │
                                  ↓
                    CONTROLLER: LaporanController
                                  │
                    ┌─────────────┼─────────────┐
                    ↓             ↓             ↓
              ┌──────────┐  ┌──────────┐  ┌──────────┐
              │ AKTIVITAS│  │  TIDUR   │  │ MAKANAN  │
              │ USER     │  │  USER    │  │  USER    │
              └──────────┘  └──────────┘  └──────────┘
                    │             │             │
         ┌──────────┴─────────────┼─────────────┴──────────┐
         │                        │                        │
    Berat Badan           Durasi Tidur          Total Kalori
    Olahraga (menit)      Kualitas Tidur        Protein
    Tanggal               Tanggal               Karbohidrat
                                                Lemak
                                                Porsi
                                                Tanggal
         │                        │                        │
         └────────────────────────┼────────────────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │  hitungStatistik()      │
                    │  (22 Metrics)           │
                    └─────────────────────────┘
                                  │
                    ┌─────────────┴──────────────┐
                    ↓                            ↓
            ┌──────────────┐            ┌──────────────┐
            │ Hari Ini:    │            │ Periode:     │
            │ - Berat      │            │ - Avg Berat  │
            │ - Tidur      │            │ - Avg Tidur  │
            │ - Olahraga   │            │ - Total Tidur│
            │ - Kalori     │            │ - Avg Kalori │
            └──────────────┘            │ - Total Kalori
                                        │ - Protein Avg
                                        │ - Karbo Avg
                                        │ - Lemak Avg
                                        │ + 10 Metrics lainnya
                                        └──────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │  buatRekomendasi()      │
                    │  (AI-based Saran)       │
                    └─────────────────────────┘
                                  │
                    ┌─────────────┴──────────────┐
                    ↓                            ↓
            ┌──────────────┐            ┌──────────────┐
            │ Cek Tidur    │            │ Cek Olahraga │
            │ Cek Kalori   │            │ Cek IMT      │
            │ Cek Nutrisi  │            │ Cek Progress │
            └──────────────┘            └──────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │  buatChartData()        │
                    │  (JSON untuk Chart.js)  │
                    └─────────────────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │   RETURN TO VIEW        │
                    │   (kesehatan-baru      │
                    │    .blade.php)          │
                    └─────────────────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │   RENDER HTML           │
                    │  (Tailwind + Icons)     │
                    └─────────────────────────┘
                                  │
                                  ↓
                    ┌─────────────────────────┐
                    │   DISPLAY TO USER       │
                    │   (Browser)             │
                    └─────────────────────────┘
```

---

## 📥 INPUT DATA SOURCES

### **1. DARI INDEKS MASA TUBUH**
```
Input Form:
├─ Berat Badan (kg)
└─ Tinggi Badan (cm)

↓ Save to:
aktivitas_user table
├─ berat_badan
├─ tinggi_badan
├─ tanggal = now()
└─ user_id

↓ Laporan menampilkan:
├─ Berat Hari Ini
├─ Berat Rata-rata Periode
├─ IMT (Indeks Massa Tubuh)
├─ Kategori IMT (Kurang/Normal/Berlebih/Obesitas)
└─ Berat Badan Ideal
```

### **2. DARI PELACAK TIDUR**
```
Input Form:
├─ Durasi Tidur (jam)
├─ Kualitas Tidur (1-10, optional)
└─ Fase Tidur (optional)

↓ Save to:
tidur_user table
├─ durasi_jam
├─ kualitas_tidur
├─ fase_tidur
├─ tanggal = now()
└─ user_id

↓ Laporan menampilkan:
├─ Tidur Hari Ini
├─ Tidur Rata-rata Periode
├─ Total Tidur Periode
├─ Status Tidur (Berkualitas/Cukup/Kurang)
└─ Riwayat 7 Hari Terakhir (Tabel)
```

### **3. DARI PELACAK NUTRISI**
```
Input Form:
├─ Pilih Makanan dari List
├─ Pilih Porsi (1-10)
└─ Add

↓ Save to:
makanan_user table
├─ makanan_id (FK to info_makanan)
├─ porsi
├─ total_kalori (hitung dari: info_makanan.kalori * porsi)
├─ tanggal = now()
└─ user_id

dan relasi ke:
info_makanan table
├─ nama_makanan
├─ kalori (per porsi default)
├─ protein
├─ karbohidrat
└─ lemak

↓ Laporan menampilkan:
├─ Kalori Hari Ini
├─ Kalori Rata-rata Periode
├─ Total Kalori Periode
├─ Kalori Target (dari user profile)
├─ Persentase Target (kalori_hari / kalori_target * 100)
├─ Protein Rata-rata
├─ Karbohidrat Rata-rata
├─ Lemak Rata-rata
└─ Riwayat Makanan 5 Hari (Tabel)
```

### **4. DARI AKTIVITAS OLAHRAGA**
```
Input Form (di Dashboard):
├─ Berat Badan (kg)
├─ Tinggi Badan (cm)
├─ Durasi Tidur (jam)
└─ Durasi Olahraga (menit)

↓ Save to:
aktivitas_user table
├─ berat_badan
├─ tinggi_badan
├─ olahraga (durasi dalam menit)
├─ jam_tidur
├─ tanggal = now()
└─ user_id

dan juga save ke:
tidur_user table (auto-sync)
├─ durasi_jam
├─ tanggal = now()
└─ user_id

↓ Laporan menampilkan:
├─ Olahraga Hari Ini
├─ Olahraga Rata-rata Periode
├─ Total Olahraga Periode
├─ Status vs Target WHO (150 min/minggu)
└─ Chart Olahraga
```

---

## 🔗 RELASI ANTAR MODELS

```
┌──────────────┐              ┌──────────────┐
│   User       │──────┬───────│ AktivitasUser│
└──────────────┘      │       └──────────────┘
      │               │              │
      │               │         ├─ berat_badan
      │               │         ├─ tinggi_badan
      │               │         ├─ olahraga
      │               │         └─ tanggal
      │               │
      │               ├────────┬─────────────┐
      │               │        │             │
      │          ┌────────┐   │      ┌────────────┐
      └──────────│TidurUser  │      │MakananUser │
                 └────────┘   │      └────────────┘
                      │       │            │
                 ├─ durasi_jam │      ├─ makanan_id (FK)
                 ├─ kualitas   │      ├─ porsi
                 └─ tanggal    │      └─ tanggal
                               │
                         ┌─────┴─────┐
                         │            │
                    ┌─────────────┐  │
                    │InfoMakanan  │←─┘
                    └─────────────┘
                         │
                    ├─ nama_makanan
                    ├─ kalori
                    ├─ protein
                    ├─ karbohidrat
                    └─ lemak
```

---

## 📈 METRICS YANG DIHITUNG (22 Total)

### **Hari Ini (4 Metrics)**
1. `berat_hari` - Berat badan hari ini (kg)
2. `tidur_hari` - Durasi tidur hari ini (jam)
3. `olahraga_hari` - Durasi olahraga hari ini (menit)
4. `kalori_hari` - Total kalori hari ini (kkal)

### **Periode Average (5 Metrics)**
5. `berat_periode_avg` - Rata-rata berat periode (kg)
6. `tidur_periode_avg` - Rata-rata tidur per hari (jam)
7. `olahraga_periode_avg` - Rata-rata olahraga per hari (menit)
8. `kalori_periode_avg` - Rata-rata kalori per hari (kkal)
9. `protein_avg` - Rata-rata protein per hari (gram)

### **Periode Total (5 Metrics)**
10. `tidur_periode_total` - Total tidur dalam periode (jam)
11. `olahraga_periode_total` - Total olahraga dalam periode (menit)
12. `kalori_periode_total` - Total kalori dalam periode (kkal)
13. `karbo_avg` - Rata-rata karbohidrat per hari (gram)
14. `lemak_avg` - Rata-rata lemak per hari (gram)

### **Progress & Perubahan (2 Metrics)**
15. `berat_perubahan` - Persentase perubahan berat (%)
16. `tidur_perubahan` - Persentase perubahan tidur (%)

### **Counts (3 Metrics)**
17. `aktivitas_periode_count` - Jumlah data aktivitas
18. `tidur_periode_count` - Jumlah data tidur
19. `makanan_periode_count` - Jumlah data makanan

### **Targets & Goals (3 Metrics)**
20. `kalori_target` - Target kalori harian (kkal)
21. `kalori_persen` - Persentase dari target kalori (%)
22. `tidur_target` - Target tidur optimal (8 jam)

---

## 🎯 REKOMENDASI AI SYSTEM

```php
Sistem Auto-Generate Rekomendasi:

1. CEK TIDUR
   if (tidur_periode_avg < 6) {
       return "Istirahat Kurang ⚠️"
   }

2. CEK OLAHRAGA
   if (olahraga_periode_total < 150) {
       return "Aktivitas Fisik Kurang ⚠️"
   }

3. CEK KALORI
   if (kalori_persen > 120) {
       return "Kalori Berlebih ℹ️"
   }

4. CEK IMT
   if (imt > 25) {
       return "IMT Tinggi ⚠️"
   }
   if (imt < 18.5) {
       return "IMT Rendah ℹ️"
   }

5. CEK PROGRESS POSITIF
   if (tidur_periode_avg >= 7) {
       return "Tidur Berkualitas ✅"
   }

6. DEFAULT MOTIVASI
   if (tidak ada warning) {
       return "Gaya Hidup Sehat! 🎉"
   }
```

---

## 🔐 CACHE STRATEGY

```
Cache Keys yang digunakan:

1. laporan_{user_id}
   Purpose: Cache seluruh data laporan
   TTL: 1 hour

2. stats_{user_id}
   Purpose: Cache hasil hitungStatistik()
   TTL: 1 hour

Cache Clear Trigger:

├─ Setiap BMI Input
├─ Setiap Tidur Input
├─ Setiap Makanan Input
├─ Setiap Olahraga Input
└─ Setiap Laporan Diakses (force clear)

Result: Data ALWAYS FRESH untuk user!
```

---

## 📱 RESPONSIVE LAYOUT

```
Desktop (> 1200px):
┌─────────────────────────────────────┐
│     Sidebar (W-64)  │  Main Content │
│                    │ (Grid: 4 cols) │
│                    │                 │
└─────────────────────────────────────┘

Tablet (768px - 1200px):
┌──────────────────┐
│  Sidebar         │
├──────────────────┤
│ Main Content     │
│ (Grid: 2 cols)   │
└──────────────────┘

Mobile (< 768px):
┌──────────────────┐
│ Menu Button      │
├──────────────────┤
│ Main Content     │
│ (Grid: 1 col)    │
│ (Scrollable)     │
└──────────────────┘
```

---

## ⚡ PERFORMANCE OPTIMIZATION

✅ **Query Optimization:**
- Pakai `with('makanan')` untuk eager loading
- Pakai `whereBetween` untuk efficient date range
- Pakai `orderBy` dengan index di database

✅ **Cache Strategy:**
- Cache hasil hitungStatistik() 1 hour
- Force clear saat user input data
- Force clear saat user akses laporan

✅ **Frontend Optimization:**
- Lazy load images
- Minify Tailwind CSS
- Use Font Awesome CDN

✅ **Database Optimization:**
- Index user_id di semua tabel
- Index tanggal untuk date range queries
- Archive old data monthly

---

**COMPLETE DOCUMENTATION DONE! ✅**
