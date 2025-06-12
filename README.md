Proyek Donasi Barang Bekas
Selamat datang di Proyek Donasi Barang Bekas! Ini adalah panduan untuk membantumu menjalankan proyek ini di lingkungan pengembangan lokal (localhost).

Daftar Isi
Prasyarat

Langkah-langkah Instalasi

Flow Pengembangan dengan Git (PENTING!)

Kontribusi

Prasyarat
Sebelum memulai, pastikan komputermu sudah terinstal perangkat lunak berikut:

PHP: Versi 8.1 atau yang lebih baru.

Composer: Manajer paket untuk PHP.

Git: Sistem kontrol versi untuk mengelola kode.

Database: Server database seperti MySQL atau MariaDB.

Langkah-langkah Instalasi
Ikuti langkah-langkah berikut untuk menjalankan aplikasi secara lokal.

1. Clone Repository
Langkah pertama adalah men-clone repository dari GitHub. Kita akan langsung mengambil branch sebas. Buka terminal atau command prompt dan jalankan perintah berikut:

git clone -b sebas https://github.com/rwbu69/donasi-barang-bekas.git

2. Masuk ke Direktori Proyek
Setelah proses clone selesai, masuk ke dalam folder proyek yang baru saja dibuat.

cd donasi-barang-bekas

3. Install Dependensi
Install semua dependensi PHP yang dibutuhkan oleh Laravel menggunakan Composer.

composer install

4. Siapkan File Environment
Salin file .env.example menjadi file .env. File ini berisi semua konfigurasi lingkungan untuk aplikasi.

cp .env.example .env

5. Generate Application Key
Setiap aplikasi Laravel membutuhkan application key yang unik. Generate kunci ini dengan perintah Artisan:

php artisan key:generate

6. Konfigurasi Database
Buka file .env yang baru saja kamu buat dengan teks editor. Cari bagian konfigurasi database dan sesuaikan dengan pengaturan database lokalmu.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=user_database_kamu
DB_PASSWORD=password_database_kamu

Penting: Pastikan kamu sudah membuat database kosong dengan nama yang sesuai (contoh: nama_database_kamu) di MySQL/MariaDB.

7. Jalankan Migrasi Database
Setelah konfigurasi database selesai, jalankan migrasi untuk membuat semua tabel yang dibutuhkan oleh aplikasi.

php artisan migrate

Opsional: Jika proyek memiliki data awal (seeder), kamu bisa menjalankannya dengan:

php artisan db:seed

8. Jalankan Server Lokal
Selesai! Sekarang kamu bisa menjalankan server pengembangan lokal Laravel.

php artisan serve

Aplikasi sekarang akan berjalan dan bisa diakses melalui URL yang ditampilkan di terminal (biasanya http://127.0.0.1:8000). 🎉

Flow Pengembangan dengan Git (PENTING!)
Untuk menjaga stabilitas kode utama, JANGAN PERNAH melakukan push langsung ke branch master atau sebas. Selalu buat branch baru untuk setiap fitur atau perbaikan yang kamu kerjakan.

Alur Kerja yang Benar:
Selalu Update Branch Utama
Sebelum mulai mengerjakan sesuatu yang baru, pastikan branch sebas lokalmu sudah yang paling baru.

git checkout sebas
git pull origin sebas

Buat Branch Baru
Buat branch baru dari branch sebas. Beri nama yang deskriptif sesuai fitur yang akan kamu buat (gunakan huruf kecil dan tanda hubung -).

# Contoh nama branch: fitur-login-google atau perbaikan-bug-halaman-utama
git checkout -b nama-fitur-baru-kamu

Mulai Bekerja
Sekarang kamu bisa mulai menulis kode, mengubah file, dan melakukan commit di branch barumu.

# Setelah membuat perubahan
git add .
git commit -m "feat: menambahkan fitur login dengan google"

Push Branch-mu ke Repository
Setelah selesai, push branch barumu ke repository remote di GitHub.

git push origin nama-fitur-baru-kamu

Buat Pull Request
Buka halaman repository di GitHub. Kamu akan melihat notifikasi untuk membuat Pull Request dari branch yang baru saja kamu push. Buatlah Pull Request agar kodemu bisa di-review oleh tim sebelum digabungkan ke branch sebas.

Kontribusi
Kontribusi sangat kami hargai! Jika kamu ingin berkontribusi, silakan buat Pull Request dengan mengikuti alur kerja yang sudah dijelaskan di atas.
