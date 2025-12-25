# 📧 Panduan Setup Email Verifikasi Password Reset

## ✅ Status Saat Ini
- ✅ Email Mailable class sudah dibuat (`App\Mail\PasswordResetMail`)
- ✅ Email template HTML sudah dibuat (`resources/views/emails/password-reset.blade.php`)
- ✅ Controller sudah updated untuk kirim email
- ✅ MAIL configuration sudah di `.env`

## 📋 Langkah Setup Email Verifikasi (Gmail)

### Step 1: Buka Google Account Settings
1. Go to: https://myaccount.google.com
2. Klik "Security" di sidebar kiri
3. Enable "2-Step Verification" (jika belum)

### Step 2: Generate App Password
1. Go to: https://myaccount.google.com/apppasswords
2. Select "Mail" di "Select the app"
3. Select "Windows Computer" (atau device yang sesuai)
4. Klik "Generate"
5. **Copy password yang muncul** (16 karakter)

### Step 3: Update .env File
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password    # Paste dari Step 2
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="FitPlus"
```

**Contoh:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pajril@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pajril@gmail.com
MAIL_FROM_NAME="FitPlus"
```

### Step 4: Restart Laravel Application
```bash
# Jika menggunakan terminal, stop server (Ctrl+C)
# Kemudian jalankan lagi:
php artisan serve
```

### Step 5: Test Email

1. Go to: `http://localhost:8000/password/reset`
2. Masukkan email Gmail Anda yang sudah dikonfigurasi
3. Klik "Kirim Link Reset"
4. **Check Gmail Inbox** - email reset password harus masuk dalam 1-2 menit

---

## 🧪 Test Flow

```
1. User klik "Lupa Password?"
   ↓
2. Input email → Klik "Kirim Link Reset"
   ↓
3. System:
   - Generate random token
   - Save token to cache (1 hour)
   - Send email with reset link
   ↓
4. Email terkirim ke Gmail inbox:
   "Halo [Nama User],
    Klik link ini untuk reset: 
    http://localhost:8000/password/reset/form?email=...&token=..."
   ↓
5. User klik link di email
   ↓
6. Masuk halaman reset password form
   ↓
7. Input password baru → Konfirmasi
   ↓
8. Success! Redirect ke login
```

---

## 📧 Email Content yang Dikirim

Dari: `FitPlus <your-email@gmail.com>`
Subject: `FitPlus - Reset Password`

Body:
```
Halo [Nama User],

Kami menerima permintaan untuk mereset password akun FitPlus Anda. 
Jika ini adalah permintaan Anda, silakan klik tombol di bawah untuk melanjutkan:

[BUTTON: Reset Password Saya]

Atau salin dan tempel link berikut di browser Anda:
http://localhost:8000/password/reset/form?email=...&token=...

⏱️ Penting: Link reset ini hanya berlaku selama 1 jam.

Jika Anda tidak meminta reset password, abaikan email ini.

© 2025 FitPlus - Aplikasi Pelacak Kesehatan
```

---

## 🔧 Troubleshooting

### ❌ "Failed to send email" error

**Penyebab:** Gmail credentials salah atau belum setup

**Solusi:**
1. Pastikan 2-Factor Authentication sudah enabled
2. Pastikan app password sudah dicopy dengan benar (tanpa space)
3. Gunakan app password, bukan password Gmail biasa

### ❌ "Connection timeout"

**Penyebab:** Port 587 blocked

**Solusi:** Coba ubah di `.env`:
```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

### ❌ Email tidak masuk ke inbox

**Penyebab:** Masuk ke folder Spam

**Solusi:**
1. Check Gmail Spam folder
2. Mark as "Not spam" untuk whitelist

---

## 📁 Files yang Berubah

✅ `app/Mail/PasswordResetMail.php` - Email Mailable class
✅ `resources/views/emails/password-reset.blade.php` - Email template
✅ `app/Http/Controllers/AuthController.php` - Updated sendPasswordReset()
✅ `.env` - MAIL configuration

---

## 🎯 After Setup Complete

✅ User bisa "Lupa Password"
✅ Email terkirim ke Gmail mereka
✅ Klik link di email → Form reset password
✅ Input password baru
✅ Berhasil login dengan password baru

**Email verification system sudah ready!** 🚀
