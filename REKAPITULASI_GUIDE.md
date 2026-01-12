# 🚀 Panduan Akses Fitur Rekapitulasi

## Langkah-Langkah:

### 1. **Buka Browser**
   - URL: http://localhost:8000/login

### 2. **Login sebagai Admin**
   - Email: `admin@hotel.local`
   - Password: `admin123`

### 3. **Setelah Login - Di Sidebar**
   Anda akan melihat sidebar kiri dengan menu:
   - Dashboard
   - Manajemen Kamar
   - Laporan Transaksi
   - Rating Tamu
   - **REKAPITULASI** ← Scroll ke sini
     - 📅 Harian
     - 📊 Mingguan
     - 📈 Bulanan
     - 📉 Tahunan
   - Biaya Operasional
   - Keuangan

### 4. **Klik Salah Satu Rekapitulasi**

**Contoh: Rekapitulasi Harian**
- Filter tanggal dengan date picker
- Lihat transaksi hari itu
- Lihat pengeluaran hari itu
- 3 stat card: Pemasukan, Pengeluaran, Profit
- Export ke CSV

---

## Troubleshooting:

### ❌ Menu Rekapitulasi tidak muncul?
**Solusi:**
1. Pastikan Anda login sebagai ADMIN (bukan kasir)
2. Refresh page dengan Ctrl+F5
3. Clear browser cache
4. Buka DevTools (F12) → Console, cek ada error?

### ❌ Halaman blank / error?
**Solusi:**
1. Buka terminal PowerShell
2. Jalankan: `php artisan serve`
3. Refresh browser
4. Cek console error

### ✅ Data tidak muncul?
- Rekapitulasi akan menampilkan data jika ada:
  - Transaksi dengan status `finished`
  - Expense pada tanggal yang dipilih
- Coba input transaksi/expense test dulu

---

## Direct Links (Akses Langsung):

**Jika ingin akses langsung tanpa klik sidebar:**

- Harian: `http://localhost:8000/recaps/daily`
- Mingguan: `http://localhost:8000/recaps/weekly`
- Bulanan: `http://localhost:8000/recaps/monthly`
- Tahunan: `http://localhost:8000/recaps/yearly`

---

Selesai! Fitur rekapitulasi sudah siap digunakan. ✅
