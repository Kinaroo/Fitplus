# 📧 GUIDE LENGKAP: Setup Gmail untuk Password Reset Email

## 🔴 MASALAH: Email Tidak Masuk ke Gmail

Kemungkinan penyebab:
1. ❌ `.env` file masih punya placeholder `your-email@gmail.com`
2. ❌ App Password belum di-generate
3. ❌ Server perlu di-restart setelah update `.env`

---

## ✅ SOLUSI: Setup Step by Step

### Step 1️⃣: Enable 2-Step Verification (Google Account)

**Kunjungi:** https://myaccount.google.com/security

1. Di sidebar kiri, cari **"Security"**
2. Scroll down sampai find **"2-Step Verification"**
3. Klik **"Enable 2-Step Verification"**
4. Follow semua instruksi (butuh nomor phone untuk verifikasi)
5. Setelah selesai, kembali ke halaman Security

---

### Step 2️⃣: Generate App Password

**PENTING:** Hanya bisa generate App Password SETELAH enable 2-Step Verification!

**Kunjungi:** https://myaccount.google.com/apppasswords

1. Di bagian atas, ada dropdown "Select the app"
   - Pilih: **Mail**
2. Di bagian dropdown kedua "Select the device"
   - Pilih: **Windows Computer** (atau device kamu)
3. Klik **"Generate"**
4. **Akan muncul 16-character password seperti ini:**
   ```
   abcd efgh ijkl mnop
   ```
5. **COPY password ini** (jangan lupa spaces-nya)

---

### Step 3️⃣: Update `.env` File

**File:** `c:\Users\ASUS\Documents\Fitplus-main\.env`

Cari section MAIL dan **REPLACE dengan data Gmail kamu:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=nama-email-kamu@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nama-email-kamu@gmail.com
MAIL_FROM_NAME="FitPlus"
```

**Contoh (dengan email asli):**
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

**⚠️ PENTING:**
- Gunakan **App Password**, bukan password Gmail biasa!
- Jangan lupa **SPACES** di password (abcd efgh ijkl mnop)
- Email harus sama di MAIL_USERNAME dan MAIL_FROM_ADDRESS

---

### Step 4️⃣: Restart Laravel Server

**Di Terminal/CMD:**

```bash
# STOP server saat ini (Ctrl + C)
Ctrl + C

# WAIT 2 detik

# Start server lagi
php artisan serve
```

**Output yang benar:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

---

### Step 5️⃣: Test Email

**Go to:** http://localhost:8000/password/reset

1. Masukkan email Gmail kamu: `pajril@gmail.com`
2. Klik **"Kirim Link Reset"**
3. **Wait 3-5 seconds**
4. **Check Gmail Inbox** → Should see email dari "FitPlus"
5. Jika tidak ada di Inbox, check **Spam/Junk folder**

---

## 🧪 Debug: Check Email Config

**Di Terminal, jalankan:**

```bash
php artisan tinker
```

**Then type:**

```php
> config('mail.default')
> config('mail.mailers.smtp.username')
> config('mail.mailers.smtp.password')
```

**Harusnya output:**
```
"smtp"
"pajril@gmail.com"
"abcd efgh ijkl mnop"
```

Jika masih placeholder, berarti `.env` belum di-update dengan benar.

---

## 🚨 Common Issues & Solutions

### ❌ Issue 1: "SMTP Connect Timeout"

**Penyebab:** Port 587 diblock
**Solusi:** Coba ubah di `.env`:
```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

---

### ❌ Issue 2: "Authentication Failed"

**Penyebab:** 
- App Password salah copy (ada space yang hilang)
- Bukan App Password, tapi Gmail biasa
- 2-Step Verification belum enabled

**Solusi:**
1. Re-generate App Password (https://myaccount.google.com/apppasswords)
2. Copy dengan teliti, jangan lupa SPACES
3. Pastikan 2FA sudah enabled

---

### ❌ Issue 3: "Email Tidak Masuk"

**Penyebab:** Email masuk ke folder Spam/Junk

**Solusi:**
1. Check Gmail Spam/Junk folder
2. Mark email as "Not spam" untuk whitelist
3. Tunggu 5-10 menit, sometimes Gmail slow

---

### ❌ Issue 4: Email Masuk Tapi Link Broken

**Penyebab:** Domain di email config tidak match actual server

**Cek di `.env`:**
```env
APP_URL=http://localhost:8000
```

Link yang di-generate akan pakai APP_URL ini. Pastikan sudah benar.

---

## ✅ Verify Setup Complete

Setelah setup selesai, test dengan:

1. ✅ Go to `/password/reset`
2. ✅ Input email
3. ✅ Click "Kirim Link Reset"
4. ✅ **Email masuk ke Gmail dalam 3-5 detik**
5. ✅ Email ada link reset password
6. ✅ Click link di email → Buka form reset password
7. ✅ Input password baru
8. ✅ Success! Redirect ke login

**Jika semua ini berhasil = Email system READY! 🎉**

---

## 📧 Email Content yang Akan Dikirim

```
From: FitPlus <pajril@gmail.com>
Subject: FitPlus - Reset Password

Halo [Nama User],

Kami menerima permintaan untuk mereset password akun FitPlus Anda.

[BUTTON: Reset Password Saya]

Atau salin link ini:
http://localhost:8000/password/reset/form?email=...&token=...

Penting: Link ini berlaku 1 jam saja.

Jika Anda tidak meminta reset, abaikan email ini.

© 2025 FitPlus
```

---

## 📝 Checklist

- [ ] Enable 2-Step Verification di Google Account
- [ ] Generate App Password dari apppasswords page
- [ ] Update `.env` dengan credentials
- [ ] Restart Laravel server
- [ ] Test password reset flow
- [ ] Email masuk di Gmail ✅

Jika sudah semua, email system ready to go! 🚀
