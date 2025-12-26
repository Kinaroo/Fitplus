# 📋 FitPlus Dashboard - Data Update Guide

## ✅ Status Fitur saat ini (Update: 11 Desember 2025)

### 1. **Statistik Hari Ini** - ✅ WORKING
- **Umur**: Ambil dari `aktivitas_user.umur` (form "Tambah Data")
- **Berat Badan**: Ambil dari `aktivitas_user.berat_badan` (form "Tambah Data")  
- **Jam Tidur**: Ambil dari `tidur_user.durasi_jam` (form "Pelacak Tidur")
- **Olahraga**: Ambil dari `aktivitas_user.olahraga` (form "Tambah Data")

### 2. **Pelacak Nutrisi** - ✅ WORKING
- **Lokasi**: Menu sidebar → "Pelacak Nutrisi"
- **Fitur**: 
  - Lihat makanan hari ini
  - Tambah makanan dari database
  - Hitung total kalori otomatis
  - Delete makanan yang salah
- **Database**: `makanan_user` table
- **Update**: Langsung setelah submit form

### 3. **Pelacak Tidur** - ✅ WORKING
- **Lokasi**: Menu sidebar → "Pelacak Tidur"
- **Fitur**:
  - Catat durasi tidur (jam)
  - Kualitas tidur (optional)
  - Fase tidur (optional)
  - Analisis otomatis
- **Database**: `tidur_user` table
- **Update**: Langsung setelah submit form

### 4. **Data Kesehatan** - ✅ WORKING
- **Lokasi**: Dashboard → Tombol "+ Tambah Data"
- **Fitur**:
  - Input: Tanggal, Umur, Berat, Tinggi, Tidur, Olahraga
  - Simpan ke table `aktivitas_user`
  - Riwayat data tampil di tabel
  - Delete data yang tidak perlu
- **Update**: Langsung setelah submit

### 5. **Laporan Kesehatan** - ✅ WORKING
- **Lokasi**: Menu sidebar → "Laporan Kesehatan"
- **Fitur**:
  - Statistik periode (7/14/30 hari)
  - IMT calculation
  - Rekomendasi personal
  - Target kesehatan
- **Data**: Dari `aktivitas_user`, `tidur_user`, `makanan_user`
- **Update**: Dinamis based on data yang ada

---

## 📝 Cara Update Data (Step by Step)

### Cara 1: Tambah Data Umum (Berat, Tinggi, Umur, Olahraga)
1. Dashboard → Klik "+ Tambah Data"
2. Isi form:
   - **Tanggal**: Pilih tanggal (default hari ini)
   - **Umur**: Masukkan umur Anda
   - **Berat Badan**: Masukkan berat (kg)
   - **Tinggi Badan**: Masukkan tinggi (cm)
   - **Jam Tidur**: Masukkan jam tidur
   - **Olahraga**: Masukkan durasi (menit)
3. Klik "Simpan"
4. Dashboard refresh otomatis

### Cara 2: Tambah Data Makanan (Nutrisi)
1. Sidebar → "Pelacak Nutrisi"
2. Form sudah ada di halaman
3. Pilih makanan dari dropdown
4. Masukkan jumlah porsi
5. Klik "Tambah"
6. Kalori otomatis dihitung

### Cara 3: Catat Tidur Harian
1. Sidebar → "Pelacak Tidur"
2. Isi form:
   - **Durasi Tidur**: Masukkan jam tidur (e.g., 7.5)
   - **Kualitas** (optional): Pilih 1-5
   - **Fase** (optional): Pilih jenis fase
3. Klik "Simpan"
4. Analisis tampil otomatis

---

## 🔧 Troubleshooting

### Dashboard Tidak Update
**Solusi**:
1. Refresh halaman (F5)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Pastikan sudah klik "Simpan" di form

### Data Tidak Tersimpan
**Check**:
1. Apakah ada error message?
2. Buka browser DevTools (F12) → Console
3. Cek server error: `tail -f storage/logs/laravel.log`

### Statistik Hari Ini Masih "-"
**Berarti**: Belum ada data untuk hari ini
**Solusi**: 
1. Klik "+ Tambah Data"
2. Masukkan data untuk hari ini
3. Refresh dashboard

---

## 📊 Data Flow Architecture

```
User Input Form
       ↓
Controller Validation
       ↓
Save ke Database Table
       ↓
Dashboard/View Query Data
       ↓
Display di Dashboard/Page
```

**Tables Used:**
- `aktivitas_user` - Berat, Tinggi, Umur, Olahraga
- `tidur_user` - Jam Tidur, Kualitas, Fase
- `makanan_user` - Makanan, Kalori, Porsi
- `info_makanan` - Database Makanan

---

## ✨ Tips Optimal

1. **Update Data Rutin**: Setiap hari untuk hasil laporan yang akurat
2. **Cek Laporan Kesehatan**: Setiap minggu untuk melihat progress
3. **Backup Data**: System sudah backup, jangan khawatir
4. **Kalori Target**: Pastikan profil sudah di-update di halaman Profil

Semua fitur sudah berfungsi dengan baik! 🎉
