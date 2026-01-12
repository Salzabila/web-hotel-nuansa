# 🏨 Hotel Nuansa - Testing Guide

## Server Running On
```
http://127.0.0.1:8000
```

## Test Accounts
| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@hotel.local` | `admin123` |
| Kasir | `kasir@hotel.local` | `kasir123` |

---

## 🧪 Feature Testing Checklist

### 1. Authentication
- [ ] Open http://127.0.0.1:8000/login
- [ ] Test login dengan `admin@hotel.local` / `admin123`
- [ ] Verify redirected to dashboard
- [ ] Test logout button
- [ ] Try login dengan `kasir@hotel.local` / `kasir123`

### 2. Dashboard (Both Roles)
- [ ] Sidebar terlihat dengan menu sesuai role
- [ ] Greeting header menampilkan nama user
- [ ] Overview stat cards tampil: Open Rate, Complete, Unique Views, Total Views
- [ ] Status Kamar grid menampilkan semua kamar

### 3. Manajemen Kamar (Admin Only)
- [ ] Buka menu "Manajemen Kamar"
- [ ] Verify list kamar tampil
- [ ] Test "Create New" kamar
- [ ] Test Edit kamar
- [ ] Test Delete kamar
- [ ] Verify Kasir tidak bisa akses menu ini (403 error jika paksa)

### 4. Check-in/Check-out (Kasir)
- [ ] Login sebagai Kasir
- [ ] Klik kamar yang available (hijau)
- [ ] Fill form: nama tamu, email, KTP, nomor HP, harga
- [ ] Submit check-in
- [ ] Verify transaction created
- [ ] Klik "Checkout" di transaction list
- [ ] Verify struk (receipt) tercetak/preview

### 5. Laporan Transaksi (Admin)
- [ ] Buka "Laporan Transaksi"
- [ ] Verify list transaksi tampil
- [ ] Test export CSV
- [ ] Verify CSV file terdownload

### 6. Rating Tamu (Admin)
- [ ] Buka "Rating Tamu"
- [ ] Verify feedback list tampil
- [ ] Check feedback dari transaksi yg sudah selesai

### 7. Biaya Operasional (Admin)
- [ ] Buka "Biaya Operasional"
- [ ] Test create expense
- [ ] Verify list expense tampil
- [ ] Check total calculation

### 8. Rekapitulasi (Admin Only)
- [ ] Buka "REKAPITULASI" → "Harian"
- [ ] Verify income/expense/net untuk hari ini
- [ ] Buka "Mingguan" → cek data minggu ini
- [ ] Buka "Bulanan" → cek data bulan ini
- [ ] Buka "Tahunan" → cek data tahun ini
- [ ] Test export daily recap (CSV)

### 9. Keuangan (Admin)
- [ ] Buka "Keuangan"
- [ ] Pilih bulan di dropdown
- [ ] Verify income, expense, dan net balance tampil

### 10. Security & Role-based Access
- [ ] Login Kasir → tidak ada "Manajemen Kamar", "REKAPITULASI", "Biaya Operasional"
- [ ] Login Admin → semua menu visible
- [ ] Test direct URL access (e.g., /rooms) sebagai Kasir → 403 error expected
- [ ] Test session: logout → tidak bisa akses protected routes

---

## 🔧 Quick Debug Tips

### Clear Cache
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Check Routes
```bash
php artisan route:list
```

### Database Reset
```bash
php artisan migrate:fresh
```

### Recreate Test Data
```bash
php artisan tinker
User::create(['name'=>'Admin','email'=>'admin@hotel.local','password'=>bcrypt('admin123'),'role'=>'admin']);
User::create(['name'=>'Kasir','email'=>'kasir@hotel.local','password'=>bcrypt('kasir123'),'role'=>'kasir']);
Room::create(['room_number'=>'101','type'=>'AC','price'=>150000,'status'=>'available']);
```

---

## 📝 Known Items

- Database: Currently using SQLite. Update `.env` to use MySQL if needed.
- Auth: Minimal custom LoginController. Production should use Breeze/Jetstream.
- Icons: Using Font Awesome CDN.
- Styling: Tailwind CSS CDN.

---

## ✅ Next Steps After Testing

1. Fix any UI/UX issues reported
2. Install Laravel Breeze for production-ready auth (optional)
3. Add more comprehensive error handling
4. Deploy to production server
