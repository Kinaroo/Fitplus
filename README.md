# FitPlus 💪

**FitPlus** adalah aplikasi web pelacakan kesehatan dan kebugaran yang komprehensif, dibangun dengan Laravel 12. Aplikasi ini membantu pengguna memantau aktivitas harian, asupan makanan, pola tidur, dan mencapai tujuan kebugaran mereka.

## ✨ Fitur Utama

### 🍽️ Pelacakan Makanan & Kalori
- Pencarian dan pencatatan makanan harian
- Perhitungan kalori otomatis
- Detail informasi gizi (protein, karbohidrat, lemak)
- Estimasi kebutuhan kalori harian

### 📊 Kalkulator BMI
- Perhitungan Body Mass Index
- Rekomendasi berdasarkan hasil BMI
- Riwayat perhitungan BMI

### 😴 Analisis Tidur
- Pencatatan durasi dan kualitas tidur
- Analisis pola tidur
- Rekomendasi untuk tidur yang lebih baik

### 🏋️ Workout & Training
- Daftar workout tersedia
- Rekomendasi workout personal
- Jadwal latihan yang dapat disesuaikan
- Pelacakan aktivitas olahraga

### 🎯 Tantangan Kebugaran
- Ikuti tantangan yang tersedia
- Buat tantangan pribadi
- Lacak progres tantangan
- Sistem pencapaian

### 📈 Laporan Kesehatan
- Laporan kesehatan komprehensif
- Export laporan ke PDF
- Analisis trend kesehatan

### 👤 Manajemen Profil
- Profil pengguna lengkap
- Data kesehatan personal
- Pengaturan tingkat aktivitas

### 🔐 Panel Admin
- Manajemen pengguna
- Manajemen tantangan
- Dashboard administrasi

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Blade Templates, Tailwind CSS 4
- **Build Tool:** Vite 7
- **Database:** MySQL
- **Testing:** PHPUnit 11

---

## 📋 Prasyarat

Sebelum instalasi, pastikan sistem Anda memiliki:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** >= 9.x
- **MySQL** >= 8.0 atau MariaDB >= 10.4
- **Git**

---

## 🚀 Panduan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Kinaroo/Fitplus.git
cd fitplus
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitplus
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database
```bash
mysql -u root -p fitplus < database/fitplus.sql
```

### 6. Install Dependensi Frontend

```bash
npm install
```

### 7. Build Assets

Untuk production:
```bash
npm run build
```

Untuk development (dengan hot reload):
```bash
npm run dev
```

### 8. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## ⚡ Quick Setup (Satu Perintah)

Jika ingin menjalankan semua langkah sekaligus:

```bash
composer setup
```

Perintah ini akan:
1. Install dependensi Composer
2. Membuat file `.env` jika belum ada
3. Generate application key
4. Menjalankan migrasi database
5. Install dependensi NPM
6. Build assets frontend

---

## 🧑‍💻 Development Mode

Untuk menjalankan server development dengan semua service:

```bash
composer dev
```

Perintah ini akan menjalankan secara bersamaan:
- Laravel development server
- Queue listener
- Log viewer (Pail)
- Vite dev server

---

## 🧪 Testing

Jalankan test suite:

```bash
composer test
```

Atau langsung dengan artisan:

```bash
php artisan test
```

---

## 📁 Struktur Proyek

```
fitpluss/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller aplikasi
│   │   └── Middleware/      # Middleware custom
│   ├── Mail/                # Mail classes
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── config/                  # File konfigurasi
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── css/                 # Stylesheet
│   ├── js/                  # JavaScript
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Route definitions
├── storage/                 # Storage files
└── tests/                   # Test files
```

---

## 🔑 Fitur Autentikasi

- Login / Register
- Password Reset via Email
- Session Management
- Admin Role Protection

---

## 📝 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan buat pull request untuk perubahan yang ingin Anda usulkan.

1. Fork repository
2. Buat branch fitur (`git checkout -b fitur/FiturBaru`)
3. Commit perubahan (`git commit -m 'Menambahkan FiturBaru'`)
4. Push ke branch (`git push origin fitur/FiturBaru`)
5. Buat Pull Request

---

## 📧 Kontak

Jika ada pertanyaan atau saran, silakan buat issue di repository ini.
