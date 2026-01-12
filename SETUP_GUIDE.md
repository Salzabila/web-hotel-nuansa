# 🏨 Hotel Nuansa - Setup & Documentation

## 📋 Project Overview
**Sistem Informasi Manajemen Hotel Nuansa** — Complete Laravel 12 hotel management system with role-based access (Admin & Kasir), guest check-in/out, room management, financial reporting, and daily/weekly/monthly/yearly recaps.

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 5.7+ (or SQLite for development)

### Installation

```bash
cd "c:\Users\LENOVO\Documents\hotel nuansa"
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh
php artisan serve --host=127.0.0.1 --port=8000
```

### Create Test Users
```bash
php artisan tinker

User::create(['name'=>'Admin','email'=>'admin@hotel.local','password'=>bcrypt('admin123'),'role'=>'admin']);
User::create(['name'=>'Kasir','email'=>'kasir@hotel.local','password'=>bcrypt('kasir123'),'role'=>'kasir']);
Room::create(['room_number'=>'101','type'=>'AC','price'=>150000,'status'=>'available']);
Room::create(['room_number'=>'102','type'=>'AC','price'=>150000,'status'=>'available']);
Room::create(['room_number'=>'201','type'=>'Kipas','price'=>100000,'status'=>'available']);

exit
```

### Login Credentials
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@hotel.local | admin123 |
| Kasir | kasir@hotel.local | kasir123 |

**URL:** http://127.0.0.1:8000/login

---

## 📁 Project Structure

```
app/Http/Controllers/
├── Auth/LoginController.php          # Login/logout logic
├── DashboardController.php           # Dashboard view (role-based)
├── TransactionController.php         # Check-in/out, receipt (struk)
├── RoomController.php                # Room CRUD (admin only)
├── ExpenseController.php             # Operational expenses (admin)
├── ReportController.php              # Reports & CSV export (admin)
├── RecapController.php               # Daily/weekly/monthly/yearly (admin)
└── FeedbackController.php            # Guest ratings

app/Http/Middleware/
└── EnsureRole.php                    # Role-based access control

app/Models/
├── User.php (with role: admin|kasir)
├── Room.php
├── Transaction.php
├── Expense.php
├── Feedback.php
└── ActivityLog.php

resources/views/
├── layouts/app.blade.php             # Main layout (sidebar + navbar)
├── auth/login.blade.php              # Login page
├── dashboard.blade.php               # Dashboard (stats + active transactions)
├── transactions/create.blade.php     # Check-in form
├── transactions/struk.blade.php      # Receipt/thermal print
├── rooms/index, create, edit         # Room management
├── expenses/index, create            # Expense management
├── reports/                          # Transactions, Feedback, Finance reports
├── feedbacks/create.blade.php        # Guest feedback form
└── recaps/                           # Daily, weekly, monthly, yearly recap
```

---

## 🎯 Core Features

### 1. Authentication
- Custom LoginController
- Session-based authentication
- Role-based redirects

### 2. Dashboard (Role-based UI)
- User greeting with name
- Overview stat cards
- Active transactions list
- Room status summary
- Quick action links (admin: reports, recap)

### 3. Check-in/Check-out (Kasir)
- Click available room → check-in form
- Capture: guest name, NIK, address, checkout datetime, KTP hold flag
- System: create transaction, set room occupied
- Checkout: finish transaction, release room
- Receipt: thermal-friendly struk with print

### 4. Room Management (Admin)
- List, Create, Edit, Delete rooms
- Status: available | occupied | maintenance
- Pricing management

### 5. Expense Tracking (Admin)
- Create operational expenses
- Date-based categorization
- Included in recap calculations

### 6. Reports (Admin)
- **Transactions:** list all check-in/out, CSV export
- **Feedback:** guest ratings & comments
- **Finance:** monthly income/expense breakdown

### 7. Recapitulation (Admin)
- **Daily:** today's income, expenses, net
- **Weekly:** current week summary
- **Monthly:** with month selector
- **Yearly:** with year selector
- **Export:** daily recap to CSV

### 8. Guest Feedback
- 5-star rating + comment (post checkout)
- Linked to transaction

---

## 🔐 Security

- **EnsureRole Middleware:** enforces role-based route access
- **Protected Routes:**
  - `/rooms` → admin only
  - `/expenses` → admin only
  - `/recaps` → admin only
  - `/reports` → admin only
  - `/transactions/checkin` → kasir only
- **CSRF Protection:** all forms include @csrf
- **Session Guard:** `Auth::check()` validates on protected routes

---

## 🎨 UI Stack
- Tailwind CSS (CDN v2.2.19)
- Font Awesome (CDN v6.0.0)
- Blade templates
- Responsive mobile-first design

---

## 📊 Database Schema

**Users:** id, name, email, password, role, timestamps  
**Rooms:** id, room_number, type, price, status, timestamps  
**Transactions:** id, room_id, user_id, guest_name, nik, address, check_in, check_out, total_price, status, is_ktp_held, timestamps  
**Expenses:** id, description, amount, date, user_id, timestamps  
**Feedbacks:** id, transaction_id, rating, comment, timestamps  
**ActivityLogs:** id, user_id, action, model, model_id, timestamps

---

## 🛠️ Configuration

### Switch to MySQL (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_nuansa
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📝 Common Commands

```bash
# Clear all caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Reset database
php artisan migrate:fresh

# List all routes
php artisan route:list

# Create user via Tinker
php artisan tinker
User::create(['name'=>'Test','email'=>'test@local','password'=>bcrypt('pass'),'role'=>'kasir']);
```

---

## ✅ Testing Checklist

See `TESTING_GUIDE.md` for comprehensive feature testing checklist.

---

## 🚀 Production Deployment

- [ ] Update `.env` with MySQL credentials
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Run `composer install --no-dev`
- [ ] Run `php artisan migrate --force`
- [ ] Configure web server (Apache/Nginx) to serve `public/` directory
- [ ] Set up HTTPS/SSL certificate
- [ ] (Optional) Install Laravel Breeze for production auth

---

**Version:** 1.0  
**Status:** ✅ Ready for Testing  
**Last Updated:** January 10, 2026
