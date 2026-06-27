# Sistem Peminjaman Barang Lab Riset (LK-10)

## Nama: Syani Carissa Syawaluna
## Nim: 24102038


[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Aplikasi manajemen data mahasiswa untuk memantau peminjaman barang di Laboratorium Riset. Proyek ini merupakan bagian dari tugas **LK-10** dan telah ditingkatkan pada **LK-11** dengan praktik pemrograman yang lebih baik.

## 🚀 Fitur Utama
- **Autentikasi Modern:** Integrasi dengan **WorkOS AuthKit** (Login via Google/SSO).
- **CRUD Mahasiswa:** Manajemen lengkap data mahasiswa (NIM, Nama, Email, Jenis Barang, Angkatan).
- **Validasi Ketat:** Menggunakan *Form Requests* untuk memastikan integritas data.
- **UI/UX Premium:** Antarmuka responsif menggunakan **Bootstrap 5** dan **Bootstrap Icons**.
- **Keamanan:** Proteksi terhadap *Mass Assignment* dan validasi *Unique Field* yang cerdas.

## 🛠️ Tech Stack
- **Backend:** [Laravel 11](https://laravel.com)
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Styling:** [Bootstrap 5](https://getbootstrap.com)
- **Auth Service:** [WorkOS](https://workos.com)
- **Database:** MySQL / MariaDB

## 📋 Prasyarat
Sebelum memulai, pastikan Anda telah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Laragon atau XAMPP (untuk database lokal)

## 🔧 Instalasi

1. **Clone repositori:**
   ```bash
   git clone <url-repositori>
   cd LK-10
   ```

2. **Instal dependensi PHP:**
   ```bash
   composer install
   ```

3. **Salin file lingkungan:**
   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi Database:**
   Buka file `.env` dan sesuaikan pengaturan database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lk_10_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Konfigurasi WorkOS:**
   Pastikan Anda mengisi API Key WorkOS di `.env`:
   ```env
   WORKOS_API_KEY=sk_test_...
   WORKOS_CLIENT_ID=client_...
   WORKOS_REDIRECT_URI=http://localhost:8000/auth/callback
   ```

6. **Generate Application Key & Migrate:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

7. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Akses di `http://localhost:8000`

## 📁 Struktur Proyek (Penting)
- `app/Http/Controllers/MahasiswaController.php`: Logika utama CRUD.
- `app/Http/Requests/MahasiswaRequest.php`: Logika validasi terpusat.
- `app/Models/Mahasiswa.php`: Representasi data mahasiswa.
- `resources/views/mahasiswa/`: File template UI (Index, Create, Edit).
- `routes/web.php`: Definisi rute aplikasi.

## 📝 Catatan Refactoring (LK-11)
Proyek ini telah melalui tahap refactoring untuk:
- Menggunakan **Route Model Binding** guna menyederhanakan kode Controller.
- Menggunakan **Form Request** untuk memisahkan validasi dari logika bisnis.
- Optimasi rute dan perbaikan UX pada pesan flash/feedback.

---
Dikembangkan dalam rangka pembelajaran Pengembangan Web.
