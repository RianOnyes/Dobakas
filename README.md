# 🌟 Berkah BaBe - Platform Donasi Barang Bekas

Sebuah platform web yang menghubungkan donatur dengan organisasi sosial untuk mendistribusikan barang bekas yang masih layak pakai.

## 📋 Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Testing](#akun-testing)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)

## 🎯 Tentang Proyek

Berkah BaBe adalah platform yang memungkinkan:
- **Donatur** untuk menyumbangkan barang bekas yang masih layak pakai
- **Organisasi sosial** untuk mencari dan mengklaim donasi yang dibutuhkan
- **Admin** untuk mengelola seluruh sistem dan memverifikasi donasi

## ✨ Fitur Utama

### Untuk Donatur
- 📝 Membuat listing donasi dengan foto dan deskripsi
- 📱 Dashboard untuk mengelola donasi
- 🔍 Mencari organisasi yang membutuhkan bantuan
- 📊 Melihat riwayat donasi

### Untuk Organisasi
- 🛒 Mengklaim donasi yang tersedia di gudang admin
- 📋 Membuat permintaan donasi spesifik
- 👥 Mengelola profil organisasi
- 📈 Dashboard dengan statistik klaim donasi

### Untuk Admin
- 🎛️ Dashboard dengan statistik lengkap
- ✅ Verifikasi donasi dari pending ke available
- 👤 Manajemen pengguna dan organisasi
- 📊 Laporan dan analitik sistem

## 🔧 Persyaratan Sistem

Pastikan sistem Anda memiliki:

- **PHP** >= 8.1
- **Composer** (latest version)
- **Node.js** >= 16.x dan **npm**
- **MySQL** >= 8.0 atau **MariaDB** >= 10.4
- **Git**
- **Web Server** (Apache/Nginx) atau menggunakan built-in server Laravel

### Software yang Direkomendasikan
- **XAMPP** (untuk Windows) - sudah include PHP, MySQL, Apache
- **MAMP** (untuk macOS)
- **LAMP** (untuk Linux)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/rwbu69/donasi-barang-bekas.git
cd donasi-barang-bekas
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies Node.js

```bash
npm install
```

### 4. Copy File Environment

```bash
# Untuk Windows
copy .env.example .env

# Untuk macOS/Linux
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

## ⚙️ Konfigurasi

### 1. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=donasi_barang_bekas
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Buat Database

Buat database baru di MySQL:

```sql
CREATE DATABASE donasi_barang_bekas;
```

### 3. Jalankan Migrasi dan Seeder

```bash
# Jalankan migrasi untuk membuat tabel
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 4. Buat Storage Link

```bash
php artisan storage:link
```

### 5. Compile Assets

```bash
# Development
npm run dev

# Atau untuk production
npm run build
```

## 🏃‍♂️ Menjalankan Aplikasi

### Metode 1: Laravel Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Metode 2: XAMPP/MAMP

1. Pindahkan folder proyek ke direktori web server (htdocs untuk XAMPP)
2. Akses melalui browser: `http://localhost/donasi-barang-bekas/public`

## 👥 Akun Testing

Setelah menjalankan seeder, Anda dapat menggunakan akun berikut untuk testing:

### Admin
- **Email:** admin@berkahbabe.com
- **Password:** password123
- **Role:** Administrator

### Donatur
- **Email:** donatur@example.com
- **Password:** password123
- **Role:** Donatur

### Organisasi
- **Email:** organisasi@example.com
- **Password:** password123
- **Role:** Organisasi

## 🎨 Tema Warna

Aplikasi menggunakan tema warna "Berkah":
- **Primary:** `#096B68` (Hijau Teal Gelap)
- **Secondary:** `#129990` (Hijau Teal)
- **Accent:** `#90D1CA` (Hijau Teal Muda)
- **Cream:** `#FFFBDE` (Krem Lembut)

## 📁 Struktur Folder Penting

```
donasi-barang-bekas/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── DonaturController.php
│   │   └── OrganisasiController.php
│   └── Models/
│       ├── User.php
│       ├── Donation.php
│       └── OrganizationDetail.php
├── resources/
│   └── views/
│       ├── admin/
│       ├── donatur/
│       ├── organisasi/
│       └── auth/
├── routes/
│   ├── web.php
│   └── auth.php
└── public/
    └── images/
```

## 🐛 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "Class 'PDO' not found"
- Pastikan PHP extension `pdo_mysql` sudah diaktifkan di `php.ini`

### Error: "Permission denied" (Linux/macOS)
```bash
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Error: "Node.js version tidak kompatibel"
- Update Node.js ke versi 16.x atau lebih baru
- Atau gunakan nvm: `nvm install 16 && nvm use 16`

### Error Database Connection
1. Pastikan MySQL/MariaDB sudah berjalan
2. Cek kredensial database di file `.env`
3. Pastikan database sudah dibuat

### Assets Tidak Muncul
```bash
npm run dev
# atau
npm run build
```

## 🔄 Update Kode

Untuk mendapatkan update terbaru:

```bash
git pull origin main
composer install
npm install
php artisan migrate
npm run dev
```

## 📝 Kontribusi

⚠️ **PENTING: JANGAN PERNAH PUSH LANGSUNG KE BRANCH MASTER!** ⚠️

### Workflow yang Benar:

1. Fork repository ini ke akun GitHub Anda
2. Clone fork Anda (bukan repository asli):
   ```bash
   git clone https://github.com/USERNAME_ANDA/donasi-barang-bekas.git
   ```
3. Tambahkan remote upstream:
   ```bash
   git remote add upstream https://github.com/rwbu69/donasi-barang-bekas.git
   ```
4. Selalu buat branch baru untuk setiap fitur/perbaikan:
   ```bash
   git checkout -b fitur-baru
   ```
5. Lakukan perubahan dan commit:
   ```bash
   git add .
   git commit -m "Menambah fitur baru"
   ```
6. Push ke fork Anda (BUKAN ke master):
   ```bash
   git push origin fitur-baru
   ```
7. Buat Pull Request dari branch Anda ke master repository asli

### Sinkronisasi dengan Repository Asli:

```bash
# Update dari repository asli
git fetch upstream
git checkout master
git merge upstream/master
git push origin master
```

### ❌ Yang TIDAK Boleh Dilakukan:
- `git push origin master` (push langsung ke master)
- `git push upstream master` (push ke repository asli)
- Commit langsung di branch master

### ✅ Yang Harus Dilakukan:
- Selalu buat branch baru untuk setiap perubahan
- Test perubahan Anda sebelum membuat PR
- Tulis commit message yang jelas dan deskriptif
- Update branch Anda dari upstream sebelum membuat PR

## 📞 Bantuan

Jika mengalami masalah saat instalasi atau menjalankan aplikasi:

1. Pastikan semua persyaratan sistem sudah terpenuhi
2. Periksa file log di `storage/logs/laravel.log`
3. Jalankan `php artisan config:clear` dan `php artisan cache:clear`
4. Buat issue di GitHub repository

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.

---

**Selamat mencoba! 🎉**

Jika ada pertanyaan atau butuh bantuan, jangan ragu untuk bertanya!
