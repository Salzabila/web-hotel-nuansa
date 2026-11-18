# Naskah Panduan Presentasi & Demo Sistem Hotel Nuansa
**Durasi Perkiraan**: 7 – 10 Menit  
**Link Live Demo**: [web-hotel-nuansa-weld.vercel.app](https://web-hotel-nuansa-weld.vercel.app)  
**Aktor / Role**: Kasir (`kasir` / `kasir`) & Admin (`admin` / `admin`)

---

## 🎬 Bagian 1: Pembuka & Latar Belakang (1 Menit)

### 🗣️ Apa yang Diucapkan:
> *"Selamat pagi/siang kepada Bapak/Ibu dosen penguji serta rekan-rekan sekalian.*
> 
> *Perkenalkan, saya **[Nama Anda]**. Pada kesempatan kali ini, saya akan mendemonstrasikan sistem informasi yang telah saya kembangkan, yaitu **Sistem Manajemen Operasional Front Office & Keuangan Hotel Nuansa**.*
> 
> *Sistem ini dirancang untuk menjawab permasalahan nyata pada hotel skala menengah, seperti pencatatan buku tamu yang masih manual, keterlambatan checkout yang luput dari pengawasan resepsionis, hingga rekonsiliasi keuangan kasir yang rawan selisih.*
> 
> *Aplikasi ini dibangun menggunakan framework **Laravel 12**, **Tailwind CSS**, dan telah dideploy secara online di cloud **Vercel** sehingga dapat diakses secara real-time dari laptop maupun smartphone staf hotel."*

---

## 🔐 Bagian 2: Akses Cloud & Autentikasi Pengguna (1 Menit)

### 🖥️ Aksi di Layar:
1. Buka browser dan tampilkan URL: `https://web-hotel-nuansa-weld.vercel.app`.
2. Tampilkan halaman login yang bersih dan responsif.
3. Masukkan Username: `kasir` dan Password: `kasir`, lalu klik tombol **Masuk**.

### 🗣️ Apa yang Diucapkan:
> *"Sebagai bukti kesiapan implementasi, sistem ini sudah live di internet dan telah terproteksi oleh enkripsi HTTPS penuh.*
> 
> *Di sini kita memiliki sistem autentikasi berbasis role (RBAC), yang membagi pengguna menjadi dua hak akses: **Kasir** untuk operasional front office sehari-hari, dan **Admin** untuk kontrol penuh atas kamar, laporan keuangan menyeluruh, serta manajemen staf.*
> 
> *Pertama-tama, mari kita masuk sebagai **Kasir**."*

---

## 🚨 Bagian 3: Dashboard & Sistem Peringatan Cerdas (2 Menit)

### 🖥️ Aksi di Layar:
1. Begitu halaman dashboard terbuka, tunjukkan **Pop-up Peringatan Checkout Terlambat** yang langsung muncul di tengah layar.
2. Jelaskan detail pop-up tersebut (nomor kamar, nama tamu, berapa lama keterlambatan).
3. Klik tombol **Tutup Peringatan**.
4. Arahkan kursor ke **Grid Status Kamar** (warna hijau, merah, kuning).
5. Tunjukkan banner peringatan tamu yang data identitasnya belum lengkap (Express Check-in).

### 🗣️ Apa yang Diucapkan:
> *"Saat kasir pertama kali membuka dashboard, sistem langsung menyajikan fitur unggulan: **Sistem Peringatan Dini (Early Warning System)**.*
> 
> *Seperti yang Bapak/Ibu lihat di layar, sebuah pop-up darurat otomatis muncul memberitahukan bahwa terdapat tamu di **Kamar 03 yang telah melewati batas checkout pukul 12:00 siang**. Kasir tidak perlu lagi memeriksa catatan kertas satu per satu; sistem langsung memberikan tombol aksi cepat untuk menghubungi tamu atau memproses checkout di tempat.*
> 
> *Setelah kita menutup pop-up, dashboard menyajikan visualisasi 32 kamar hotel secara real-time:*
> - *Kamar warna **Hijau** artinya siap huni (Available).*
> - *Kamar warna **Merah** sedang terisi (Occupied) dengan indikator sisa jam menginap.*
> - *Kamar warna **Kuning** adalah kamar kotor (Dirty) pasca-checkout yang membutuhkan pembersihan housekeeping.*
> 
> *Selain itu, terdapat banner peringatan identitas tamu belum lengkap, yang memastikan tidak ada tamu yang checkout tanpa meninggalkan data identitas resmi."*

---

## 🏨 Bagian 4: Operasional Front Office & Check-In (2 Menit)

### 🖥️ Aksi di Layar:
1. Klik menu **Front Office** (atau klik salah satu kamar warna hijau di grid).
2. Tunjukkan formulir check-in.
3. Pilih kamar (misal: Kamar 07 - Standard Kipas).
4. Masukkan nama tamu: `Bpk. Hendra`, NIK, nomor HP, durasi `1 malam`.
5. Tunjukkan dropdown **Metode Pembayaran** (Cash, Transfer BCA, Mandiri, QRIS).
6. Pilih metode pembayaran, lalu klik **Check In Sekarang**.

### 🗣️ Apa yang Diucapkan:
> *"Sekarang mari kita masuk ke menu **Front Office** untuk alur pelayanan tamu baru.*
> 
> *Di sini proses check-in dirancang sangat cepat. Resepsionis cukup memilih kamar yang tersedia, memasukkan identitas tamu, dan menentukan durasi menginap.*
> 
> *Sistem kami telah mendukung berbagai opsi pembayaran modern: mulai dari uang tunai (Cash), transfer antar bank, hingga pembayaran non-tunai berbasis QRIS.*
> 
> *Begitu tombol check-in ditekan, sistem otomatis mengunci kamar menjadi berstatus 'Occupied', menerbitkan bukti tanda terima digital, dan mencatat transaksi ke dalam buku tamu secara otomatis."*

---

## 💳 Bagian 5: Checkout Cepat & Penerbitan Struk (2 Menit)

### 🖥️ Aksi di Layar:
1. Kembali ke Dashboard / Front Office.
2. Klik tombol **Checkout** pada salah satu kamar yang terisi (misal Kamar 03 atau kamar yang baru dibuat).
3. Modal Checkout Cepat akan muncul.
4. Masukkan biaya tambahan (misal: *Laundry & Overtime* sebesar `Rp 30.000`).
5. Perhatikan kalkulasi total akhir yang ter-update otomatis secara real-time.
6. Klik tombol **Proses Checkout**.
7. Tunjukkan halaman **Struk Pembayaran / Invoice** yang siap dicetak ke thermal printer atau disimpan sebagai PDF.

### 🗣️ Apa yang Diucapkan:
> *"Selanjutnya adalah alur saat tamu hendak keluar (Checkout).*
> 
> *Kasir cukup menekan tombol **Checkout** langsung dari dashboard. Modal checkout interaktif akan menghitung total biaya sewa kamar.*
> 
> *Apabila tamu menggunakan fasilitas tambahan—misalnya laundry, minibar, atau terkena denda keterlambatan (overtime)—kasir cukup mengetikkan nominalnya di kolom biaya tambahan, dan kalkulator sistem akan menjumlahkannya secara otomatis tanpa resiko salah hitung manual.*
> 
> *Setelah diproses, sistem langsung menerbitkan **Struk Pembayaran Resmi** yang kompatibel dengan printer kasir thermal dan langsung mengubah status kamar menjadi **Kuning (Dirty)** agar tim kebersihan segera menyiapkan kamar untuk tamu berikutnya."*

---

## 📊 Bagian 6: Pengeluaran Operasional & Laporan Keuangan (1.5 Menit)

### 🖥️ Aksi di Layar:
1. Klik menu **Pengeluaran** di sidebar $\rightarrow$ tunjukkan riwayat belanja operasional dan tombol **Tambah Pengeluaran**.
2. Klik menu **Laporan** $\rightarrow$ tunjukkan grafik pemasukan, persentase tingkat hunian (occupancy rate), dan tabel rekapitulasi.
3. Tunjukkan tombol ekspor: **Export PDF** dan **Export Excel**.

### 🗣️ Apa yang Diucapkan:
> *"Salah satu keunggulan sistem Hotel Nuansa adalah transparansi arus kas.*
> 
> *Melalui menu **Pengeluaran**, kasir dan manajemen dapat mencatat setiap pengeluaran kas kecil operasional hotel, seperti pembelian air galon, gas, atau biaya pemeliharaan berkala lengkap dengan kategorinya.*
> 
> *Seluruh pemasukan dari sewa kamar dan pengeluaran operasional ini dikonsolidasikan secara otomatis di halaman **Laporan Keuangan**. Manajemen dapat melihat omzet harian, mingguan, maupun bulanan, serta mengunduh dokumen laporan dalam format **PDF resmi maupun lembar kerja Excel** hanya dengan satu kali klik."*

---

## 👑 Bagian 7: Tinjauan Role Admin & Keamanan Sistem (30 Detik)

### 🖥️ Aksi di Layar:
1. Klik avatar kasir di pojok kanan atas $\rightarrow$ klik **Keluar (Logout)**.
2. Login sebagai Admin: Username **`admin`** | Password **`admin`**.
3. Tunjukkan menu tambahan yang hanya dimiliki admin: **Pengguna (Kelola Staf)** dan **Kamar (CRUD Kamar)**.

### 🗣️ Apa yang Diucapkan:
> *"Terakhir, jika kita logout dan masuk menggunakan akun **Admin**, kita dapat melihat menu proteksi manajemen:*
> - *Admin dapat menambah, mengubah tarif, atau menghapus tipe kamar.*
> - *Admin dapat mengelola hak akses akun staf kasir serta mereset kata sandi staf.*
> 
> *Pemisahan hak akses ini memastikan keamanan integritas data hotel agar tidak disalahgunakan."*

---

## 🎯 Bagian 8: Penutup & Tanya Jawab (30 Detik)

### 🗣️ Apa yang Diucapkan:
> *"Sebagai kesimpulan, **Sistem Informasi Hotel Nuansa** telah berhasil memodernisasi seluruh proses operasional hotel: mulai dari pencegahan kamar terlambat checkout dengan early warning system, fleksibilitas pembayaran modern, hingga laporan keuangan otomatis yang siap pakai.*
> 
> *Sistem ini sudah 100% stabil, telah melalui tahap pengujian teknis, dan siap diterapkan pada operasional hotel sebenarnya.*
> 
> *Demikian presentasi dan demonstrasi dari saya. Terima kasih atas perhatian Bapak/Ibu dosen penguji, dan saya persilakan jika ada pertanyaan atau masukan.*
> 
> *Wassalamu'alaikum Warahmatullahi Wabarakatuh."*

---

## 💡 Tips & Jawaban Cepat Jika Dosen Bertanya (Q&A Cheat Sheet)

| Kemungkinan Pertanyaan Dosen | Jawaban Singkat & Tepat |
| :--- | :--- |
| **Q: Di mana aplikasi ini di-hosting?** | *"Aplikasi ini di-deploy di platform cloud **Vercel** dengan arsitektur serverless PHP runtime 8.2 dan menggunakan enkripsi SSL HTTPS penuh."* |
| **Q: Bagaimana jika tamu checkout terlambat?** | *"Sistem memiliki logic otomatis berbasis Carbon timezone Asia/Jakarta yang mendeteksi batas jam 12:00 WIB. Kamar yang lewat waktu akan memicu pop-up peringatan merah di dashboard dan kasir dapat menambahkan denda overtime pada form checkout."* |
| **Q: Mengapa data tamu kadang ada peringatan 'Belum Lengkap'?** | *"Sistem menyediakan fitur Express Check-in untuk tamu yang terburu-buru. Namun sistem memberi flag proteksi agar resepsionis wajib melengkapi nomor NIK di buku tamu digital sebelum tamu checkout."* |
| **Q: Database apa yang digunakan?** | *"Untuk demo cloud saat ini menggunakan SQLite yang disinkronkan ke memori serverless, dan kami juga telah menyiapkan skrip ekspor MySQL/MariaDB (`database_hotel_nuansa.sql`) jika ingin dipindahkan ke cPanel hosting mandiri."* |
