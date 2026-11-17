# Panduan Lengkap Deploy Hotel Nuansa ke Web Hosting / cPanel

Panduan ini disusun langkah demi langkah agar aplikasi **Hotel Nuansa** dapat langsung aktif dan berjalan lancar di cPanel Shared Hosting atau Cloud Hosting tanpa memerlukan instalasi Composer via terminal SSH.

---

## 📦 Berkas Deployment yang Telah Disiapkan

Dalam folder proyek Anda telah disiapkan:
1. **`hotel-nuansa-cpanel.zip`** : Arsip lengkap aplikasi (sudah termasuk dependensi `vendor/` dan aset frontend terkompilasi).
2. **`database_hotel_nuansa.sql`** : File skrip database siap import (MySQL / MariaDB) yang sudah terisi data akun admin/kasir, kamar, dan kategori.
3. **`.env.production`** : Template konfigurasi database dan environment untuk server produksi.
4. **`.htaccess`** : Konfigurasi keamanan dan pengalihan trafik otomatis ke `public/`.

---

## 🛠️ Langkah 1: Buat Database MySQL di cPanel

1. Masuk ke dashboard **cPanel** akun hosting Anda.
2. Cari menu **MySQL® Databases** (atau **MySQL Database Wizard**).
3. Buat database baru, contoh: `u123456_hotelnuansa`.
4. Buat user database baru, contoh: `u123456_hoteluser` dengan password yang aman (misal: `P@ssw0rdNuansa2026!`).
5. **Tambahkan User ke Database**:
   - Pilih User dan Database yang baru dibuat.
   - Klik **Add**.
   - Centang **ALL PRIVILEGES** (Semua Hak Akses).
   - Klik **Make Changes**.
6. Simpan informasi berikut untuk konfigurasi nanti:
   - **Nama Database**: `u123456_hotelnuansa`
   - **User Database**: `u123456_hoteluser`
   - **Password**: `P@ssw0rdNuansa2026!`

---

## 📥 Langkah 2: Import Database via phpMyAdmin

1. Di menu cPanel, buka **phpMyAdmin**.
2. Pada panel sebelah kiri, klik nama database yang baru Anda buat (`u123456_hotelnuansa`).
3. Klik tab **Import** pada menu navigasi atas.
4. Klik tombol **Choose File** (Pilih Berkas) lalu pilih file **`database_hotel_nuansa.sql`**.
5. Gulir ke bawah dan klik tombol **Import** (atau **Go**).
6. Tunggu hingga muncul pesan hijau sukses (*Import has been successfully finished*).

---

## 🚀 Langkah 3: Upload dan Ekstrak File Aplikasi

Pilih salah satu dari 2 metode struktur di bawah ini sesuai kenyamanan Anda:

### METODE A: Struktur Standar (Paling Mudah & Cepat)
*Cocok jika Anda ingin mengunggah langsung ke `public_html` atau ke subdomain (misal `hotel.domainanda.com`).*

1. Buka **File Manager** di cPanel.
2. Masuk ke folder target:
   - Jika domain utama: masuk ke **`public_html`**.
   - Jika subdomain: masuk ke folder subdomain terkait (misal **`public_html/hotel`**).
3. Klik tombol **Upload** di menu atas.
4. Unggah file **`hotel-nuansa-cpanel.zip`**.
5. Setelah upload selesai (100% dan berwarna hijau), kembali ke File Manager lalu klik kanan file `hotel-nuansa-cpanel.zip` dan pilih **Extract**.
6. Pastikan file root `.htaccess` ikut terekstrak (file ini yang otomatis mengarahkan pengunjung ke folder `public/` dan memblokir akses ke file rahasia).

---

### METODE B: Struktur Terpisah / Best Practice Laravel (Paling Aman)
*Memisahkan file inti sistem di luar `public_html` agar kode program tidak dapat diakses langsung oleh web browser.*

1. Di **File Manager**, pergi ke folder paling atas (`/home/username/`).
2. Buat folder baru bernama **`hotel_core`**.
3. Upload dan ekstrak **`hotel-nuansa-cpanel.zip`** ke dalam folder `hotel_core`.
4. Pindahkan seluruh isi folder **`hotel_core/public/`** ke dalam folder **`public_html/`**.
5. Buka dan edit file `public_html/index.php`:
   Ubah baris:
   ```php
   // Baris 9
   if (file_exists($maintenance = __DIR__.'/../hotel_core/storage/framework/maintenance.php')) {
       require $maintenance;
   }

   // Baris 14
   require __DIR__.'/../hotel_core/vendor/autoload.php';

   // Baris 18
   $app = require_once __DIR__.'/../hotel_core/bootstrap/app.php';
   ```
6. Simpan perubahan (*Save Changes*).

---

## ⚙️ Langkah 4: Konfigurasi File `.env`

1. Di cPanel File Manager, pastikan opsi **Show Hidden Files (dotfiles)** aktif (dapat diatur di pojok kanan atas menu *Settings*).
2. Cari file bernama **`.env.production`** pada folder aplikasi Anda, lalu ubah namanya (Rename) menjadi **`.env`**.
3. Klik kanan file **`.env`** lalu pilih **Edit**.
4. Sesuaikan baris-baris berikut dengan data hosting Anda:
   ```env
   APP_NAME="Hotel Nuansa"
   APP_ENV=production
   APP_KEY=base64:rJys2SQ1YK8dqs46fzvSF8qgrX6ZK81QYHm5qqSuUBw=
   APP_DEBUG=false
   APP_URL=https://namadomainanda.com

   # Konfigurasi Database cPanel
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u123456_hotelnuansa
   DB_USERNAME=u123456_hoteluser
   DB_PASSWORD=P@ssw0rdNuansa2026!
   ```
5. Klik **Save Changes**.

---

## 🔒 Langkah 5: Hak Akses Folder (Permissions)

Untuk memastikan sistem dapat menulis log transaksi dan session:
1. Pastikan folder **`storage`** dan seluruh sub-foldernya memiliki hak akses **775** atau **755**.
2. Pastikan folder **`bootstrap/cache`** memiliki hak akses **775** atau **755**.

---

## 🔑 Akun Login Bawaan Sistem

Setelah aplikasi berhasil diakses melalui browser:
* **URL Login**: `https://namadomainanda.com/login`
* **Akun Admin**:
  - Username: `admin` (atau email: `admin@nuansa.local`)
  - Password: `admin`
* **Akun Kasir**:
  - Username: `kasir` (atau email: `kasir@nuansa.local`)
  - Password: `kasir`

> **Catatan Keamanan**: Begitu berhasil login untuk pertama kali, masuk ke menu manajemen staf/profil untuk mengganti password default demi keamanan sistem hotel Anda.
