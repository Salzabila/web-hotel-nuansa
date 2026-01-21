# Role-Based Access Control System
## Hotel Nuansa Management System

---

## 📂 File Structure & Role System

### 1. **Authentication & Middleware**

#### `app/Http/Middleware/IsAdmin.php`
```
Fungsi: Memblokir akses kasir ke route admin-only
Logic:
- if role = 'admin' → allow
- if role = 'kasir' → redirect to dashboard with warning
- else → redirect to login
```

**Routes yang dilindungi:**
- Manajemen Kamar (CRUD)
- Pengeluaran Operasional
- Laporan Keuangan
- Rekapitulasi
- Feedback Management

---

### 2. **Controllers**

#### `app/Http/Controllers/DashboardController.php`
```php
index()
├── Cek role user
├── if kasir → kasirDashboard()
└── if admin → adminDashboard()

kasirDashboard()
├── Data: rooms, stats, active transactions
└── View: dashboard-kasir.blade.php

adminDashboard()
├── Data: rooms, stats, maintenance info
└── View: dashboard.blade.php
```

#### `app/Http/Controllers/TransactionController.php`
```
Accessible by: ADMIN & KASIR
Methods:
- index() → List all transactions
- create() → Check-in form
- store() → Process check-in
- show() → Transaction detail
- showCheckout() → Checkout form
- processCheckout() → Process checkout
- struk() → Print receipt
```

#### `app/Http/Controllers/RoomController.php`
```
viewAll() → Accessible by: ADMIN & KASIR (read-only)
index()   → Accessible by: ADMIN only
create()  → Accessible by: ADMIN only
store()   → Accessible by: ADMIN only
edit()    → Accessible by: ADMIN only
update()  → Accessible by: ADMIN only
destroy() → Accessible by: ADMIN only
```

#### Admin-Only Controllers:
- `ExpenseController.php` → Pengeluaran operasional
- `FinancialReportController.php` → Laporan keuangan
- `ReportController.php` → Laporan transaksi & feedback
- `RecapController.php` → Rekapitulasi harian/bulanan
- `FeedbackController.php` → Manajemen feedback tamu

---

### 3. **Views**

#### Dashboard Views
```
resources/views/
├── dashboard.blade.php           [ADMIN ONLY]
│   ├── Full statistics
│   ├── Room grid (all clickable)
│   ├── Active transactions table
│   └── Quick actions
│
└── dashboard-kasir.blade.php     [KASIR ONLY]
    ├── Limited statistics
    ├── Room grid (only available clickable)
    ├── Active transactions table
    └── Check-in/Check-out actions only
```

#### Shared Views (Both Roles)
```
resources/views/transactions/
├── index.blade.php    → List all transactions
├── show.blade.php     → Transaction detail
├── create.blade.php   → Check-in form
├── checkout.blade.php → Checkout form
└── struk.blade.php    → Receipt printer
```

#### Admin-Only Views
```
resources/views/
├── rooms/
│   ├── index.blade.php   → Room management table
│   ├── create.blade.php  → Add new room
│   └── edit.blade.php    → Edit room
├── expenses/
│   ├── index.blade.php   → Expense list
│   └── create.blade.php  → Add expense
├── reports/
│   ├── financial.blade.php  → Financial report
│   ├── transactions.blade.php → Transaction report
│   └── feedback.blade.php   → Feedback report
├── recaps/
│   ├── daily.blade.php    → Daily recap
│   ├── weekly.blade.php   → Weekly recap
│   ├── monthly.blade.php  → Monthly recap
│   └── yearly.blade.php   → Yearly recap
└── feedbacks/
    ├── index.blade.php → Feedback list
    └── show.blade.php  → Feedback detail
```

#### Accessible by Both (Read-only for Kasir)
```
resources/views/rooms/
└── all.blade.php → Full room grid (kasir can't edit)
```

---

### 4. **Routes** (`routes/web.php`)

#### Public Routes
```php
Route::get('login') → LoginController@showLoginForm
Route::post('login') → LoginController@login
```

#### Authenticated Routes (Both Roles)
```php
Route::middleware('auth')->group(function () {
    Route::get('/') → dashboard [ROLE-BASED VIEW]
    
    // Transactions (Full Access)
    Route::get('transactions') → index
    Route::get('transactions/{id}') → show
    Route::get('transactions/checkin/{room}') → create
    Route::post('transactions/checkin/{room}') → store
    Route::get('transactions/checkout/{id}') → showCheckout
    Route::post('transactions/checkout/{id}') → processCheckout
    Route::get('transactions/struk/{id}') → struk
    
    // Rooms (Read-only for Kasir)
    Route::get('rooms-all') → viewAll
});
```

#### Admin-Only Routes
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Room Management (CRUD)
    Route::resource('rooms', RoomController::class);
    
    // Expenses
    Route::get('expenses') → index
    Route::get('expenses/create') → create
    Route::post('expenses') → store
    
    // Reports
    Route::get('reports/finance') → FinancialReportController
    Route::get('reports/transactions') → ReportController
    Route::get('reports/feedback') → ReportController
    
    // Recaps
    Route::get('recaps/daily') → RecapController
    Route::get('recaps/weekly') → RecapController
    Route::get('recaps/monthly') → RecapController
    Route::get('recaps/yearly') → RecapController
    Route::get('recaps/export-*') → RecapController
    
    // Feedbacks
    Route::get('feedbacks') → index
    Route::get('feedbacks/{id}') → show
    Route::put('feedbacks/{id}/status') → updateStatus
});
```

---

### 5. **Sidebar Navigation** (`resources/views/layouts/app.blade.php`)

#### Kasir Menu
```
📱 MENU UTAMA
├── 🏠 Beranda (Dashboard Kasir)
├── 🔄 Transaksi [badge: active count]
└── 🚪 Lihat Kamar (opens in new tab)
```

#### Admin Menu
```
📱 MENU UTAMA
├── 🏠 Beranda (Dashboard Admin)
├── 🛏️ Kamar [badge: total count]
└── 🔄 Transaksi [badge: active count]

📊 MANAJEMEN
├── 💰 Pengeluaran
├── 📈 Laporan
├── 📅 Rekap Harian
└── 💬 Feedback [badge: total count]
```

---

## 🔄 User Flow Diagrams

### **ADMIN FLOW**

```
┌─────────────────────────────────────────────────────────┐
│                    LOGIN (admin)                         │
│              username: admin | password: admin123        │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                 DASHBOARD ADMIN                          │
│  ┌──────────────────────────────────────────────────┐   │
│  │ • Total Kamar | Tersedia | Terisi | Omset       │   │
│  │ • Room Grid (all cards clickable)               │   │
│  │ • Active Transactions Table                      │   │
│  └──────────────────────────────────────────────────┘   │
└───┬─────────┬──────────┬──────────┬──────────┬─────────┘
    │         │          │          │          │
    │         │          │          │          │
    ▼         ▼          ▼          ▼          ▼
┌────────┐ ┌─────┐  ┌─────────┐ ┌────────┐ ┌──────────┐
│ KAMAR  │ │TRANS│  │PENGELU- │ │LAPORAN │ │FEEDBACK  │
│ (CRUD) │ │AKSI │  │  ARAN   │ │        │ │          │
└───┬────┘ └──┬──┘  └────┬────┘ └───┬────┘ └────┬─────┘
    │         │          │          │          │
    ▼         ▼          ▼          ▼          ▼
┌─────────────────────────────────────────────────────┐
│ • Add Room        • Check-in    • Add Expense       │
│ • Edit Room       • Check-out   • View Report       │
│ • Delete Room     • View Detail • Export Excel      │
│ • Change Status   • Print Struk • Daily/Monthly     │
└─────────────────────────────────────────────────────┘
```

---

### **KASIR FLOW**

```
┌─────────────────────────────────────────────────────────┐
│                    LOGIN (kasir)                         │
│              username: kasir | password: kasir123        │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                 DASHBOARD KASIR                          │
│  ┌──────────────────────────────────────────────────┐   │
│  │ • Total Kamar | Tersedia | Terisi | Omset       │   │
│  │ • Room Grid (only green cards clickable)        │   │
│  │ • Active Transactions Table + Check-out button  │   │
│  └──────────────────────────────────────────────────┘   │
└───┬─────────────────────┬───────────────────────────────┘
    │                     │
    │                     │
    ▼                     ▼
┌──────────────┐     ┌──────────────┐
│  CHECK-IN    │     │  CHECK-OUT   │
│  (GREEN      │     │  (FROM       │
│   ROOM)      │     │   TABLE)     │
└──────┬───────┘     └──────┬───────┘
       │                    │
       ▼                    ▼
┌─────────────────────────────────────────┐
│ TRANSAKSI                                │
│ ├── View Transaction List               │
│ ├── View Detail                         │
│ ├── Print Struk/Receipt                 │
│ └── Lihat Semua Kamar (read-only)      │
└─────────────────────────────────────────┘

❌ TIDAK BISA AKSES:
   • Manajemen Kamar (add/edit/delete)
   • Pengeluaran
   • Laporan
   • Rekapitulasi
   • Feedback Management
```

---

## 🔐 Access Control Matrix

| Feature                    | Admin | Kasir |
|----------------------------|:-----:|:-----:|
| **Dashboard**              |       |       |
| View Dashboard             | ✅    | ✅    |
| Full Statistics            | ✅    | ❌    |
| Room Grid (Edit)           | ✅    | ❌    |
| Room Grid (View)           | ✅    | ✅    |
|                            |       |       |
| **Transactions**           |       |       |
| Check-in                   | ✅    | ✅    |
| Check-out                  | ✅    | ✅    |
| View List                  | ✅    | ✅    |
| View Detail                | ✅    | ✅    |
| Print Receipt              | ✅    | ✅    |
|                            |       |       |
| **Room Management**        |       |       |
| View All Rooms             | ✅    | ✅    |
| Add Room                   | ✅    | ❌    |
| Edit Room                  | ✅    | ❌    |
| Delete Room                | ✅    | ❌    |
| Change Room Status         | ✅    | ❌    |
|                            |       |       |
| **Operational Expenses**   |       |       |
| View Expenses              | ✅    | ❌    |
| Add Expense                | ✅    | ❌    |
|                            |       |       |
| **Reports**                |       |       |
| Financial Report           | ✅    | ❌    |
| Transaction Report         | ✅    | ❌    |
| Feedback Report            | ✅    | ❌    |
| Export to Excel            | ✅    | ❌    |
|                            |       |       |
| **Recapitulation**         |       |       |
| Daily Recap                | ✅    | ❌    |
| Weekly Recap               | ✅    | ❌    |
| Monthly Recap              | ✅    | ❌    |
| Yearly Recap               | ✅    | ❌    |
| Export Recap               | ✅    | ❌    |
|                            |       |       |
| **Feedback**               |       |       |
| View Feedbacks             | ✅    | ❌    |
| Update Feedback Status     | ✅    | ❌    |

---

## 📝 Database Schema - Users

```sql
users
├── id (primary key)
├── name (string)
├── email (string, unique)
├── username (string, unique)
├── password (hashed)
├── role (enum: 'admin', 'kasir')
├── email_verified_at
├── created_at
└── updated_at
```

### Default Users (from Seeder)

```
ADMIN:
├── Name: Admin Nuansa
├── Email: admin@nuansa.local
├── Username: admin
├── Password: admin123
└── Role: admin

KASIR:
├── Name: Kasir Nuansa
├── Email: kasir@nuansa.local
├── Username: kasir
├── Password: kasir123
└── Role: kasir
```

---

## 🚀 Quick Commands

### Create Fresh Database
```bash
php artisan migrate:fresh --seed
```

### Clear All Cache
```bash
php artisan optimize:clear
```

### Start Development Server
```bash
php artisan serve
```

### Access Application
```
Admin:  http://localhost:8000/login
        username: admin | password: admin123

Kasir:  http://localhost:8000/login
        username: kasir | password: kasir123
```

---

## 🎯 Summary

### Admin Capabilities:
- **Full System Access** - CRUD semua resource
- **Dashboard Admin** - Statistik lengkap + management tools
- **Room Management** - Add, edit, delete, change status
- **Financial Control** - Expenses, reports, recapitulation
- **Feedback Management** - View dan update status

### Kasir Capabilities:
- **Operational Tasks** - Check-in, check-out, print receipt
- **Dashboard Kasir** - Simplified interface, fokus transaksi
- **Transaction Management** - View list, detail, active transactions
- **Read-only Room View** - Lihat status kamar (tidak bisa edit)
- **No Administrative Access** - Tidak bisa akses laporan, expenses, dll

### Security Features:
- ✅ Role-based routing dengan middleware
- ✅ Sidebar dinamis berdasarkan role
- ✅ View terpisah untuk admin dan kasir
- ✅ Access control di controller level
- ✅ Redirect otomatis jika akses unauthorized

---

**Last Updated:** January 13, 2026
**System Version:** Laravel 11.x
**Project:** Hotel Nuansa Management System
