# Setup Email Notifikasi Pengumuman

## Fitur yang Sudah Dibuat

✅ **Notification Class**: `NewAnnouncementNotification`  
✅ **Email Template**: Template HTML yang menarik  
✅ **Controller Update**: Auto kirim email saat buat pengumuman  
✅ **Form Update**: Checkbox untuk opsi kirim email  
✅ **Command Testing**: `php artisan test:announcement-email`

## Cara Setup Email

### 1. Konfigurasi Environment (.env)

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="RT/RW System"
```

### 2. Untuk Gmail
1. Aktifkan **2-Factor Authentication**
2. Buat **App Password** di Google Account Settings
3. Gunakan App Password sebagai `MAIL_PASSWORD`

### 3. Untuk Mailtrap (Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

## Cara Penggunaan

### 1. Buat Pengumuman dengan Email
1. Login sebagai Admin/RT/RW
2. Buka menu "Pengumuman" → "Buat Pengumuman"
3. Isi judul dan konten
4. **Centang** "Kirim email notifikasi ke semua warga"
5. Klik "Simpan"

### 2. Testing Email
```bash
# Test ke user pertama dengan role warga
php artisan test:announcement-email

# Test ke email tertentu
php artisan test:announcement-email user@example.com
```

## Fitur Email

### 📧 Template Email
- **Design**: Responsive HTML dengan styling modern
- **Content**: Judul, isi pengumuman, tanggal, link
- **Branding**: Logo RT/RW dan warna tema

### 📬 Notifikasi Otomatis
- **Target**: Semua warga dengan status "disetujui"
- **Trigger**: Saat admin buat pengumuman baru
- **Error Handling**: Log error jika gagal kirim

### ⚙️ Opsi Kontrol
- **Checkbox**: Admin bisa pilih kirim email atau tidak
- **Selective**: Hanya warga yang sudah disetujui
- **Batch**: Kirim ke semua warga sekaligus

## Troubleshooting

### Email Tidak Terkirim
1. Cek konfigurasi SMTP di `.env`
2. Pastikan credentials benar
3. Test dengan command: `php artisan test:announcement-email`
4. Cek log error di `storage/logs/laravel.log`

### Gmail Issues
1. Pastikan 2FA aktif
2. Gunakan App Password, bukan password biasa
3. Cek "Less secure app access" jika perlu

### Mailtrap (Development)
1. Daftar di mailtrap.io
2. Copy credentials dari inbox
3. Email akan masuk ke Mailtrap inbox (tidak ke email asli)

## Keamanan

- ✅ Email hanya dikirim ke warga yang sudah disetujui
- ✅ Error handling untuk mencegah crash
- ✅ Logging untuk monitoring
- ✅ Opsi kontrol untuk admin

## Contoh Email yang Dikirim

```
Subject: Pengumuman Baru: Rapat Warga Minggu Ini

Halo [Nama Warga]! 👋

Ada pengumuman baru dari RT/RW yang perlu Anda ketahui:

📢 Rapat Warga Minggu Ini
Isi pengumuman...
📅 Tanggal: 28/06/2025 10:30

[Button] 📋 Lihat Semua Pengumuman

Terima kasih telah menggunakan layanan RT/RW kami.
Salam, Tim RT/RW 