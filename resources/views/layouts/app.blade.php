<!doctype html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <style>
    :root {
      --primary: #2d6cea;
      --primary-dark: #1a4fc4;
      --primary-light: #e8f0fe;
      --secondary: #10b981;
      --accent: #f59e0b;
      --dark: #1e293b;
      --light: #f8fafc;
      --gray: #64748b;
      --gray-light: #e2e8f0;
      --border-radius: 16px;
      --shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Custom slate-400 color for dirty room status */
    .bg-slate-400 {
      background-color: #94a3b8 !important;
    }

    * { 
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    html {
      font-size: 16px;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      height: 100%;
      overflow: hidden;
    }

    body { 
      display: flex;
      height: 100vh;
      margin: 0;
      padding: 0;
      background-color: #F0F4F8;
      color: var(--dark);
      font-size: 1rem;
      line-height: 1.5;
      overflow: hidden;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 256px;
      height: 100vh;
      background: white;
      color: #475569;
      display: flex;
      flex-direction: column;
      transition: var(--transition);
      position: fixed;
      left: 0;
      top: 0;
      z-index: 100;
      border-right: 1px solid #e2e8f0;
      overflow-y: auto;
    }

    .sidebar::before {
      display: none;
    }

    /* Logo & Header */
    .sidebar-header {
      padding: 28px 24px 20px;
      border-bottom: 1px solid #e2e8f0;
      background: white;
    }

    .logo-container {
      display: flex;
      align-items: center;
      margin-bottom: 16px;
    }

    .logo-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      box-shadow: 0 4px 12px rgba(45, 108, 234, 0.3);
      color: white;
    }

    .logo-icon i {
      font-size: 20px;
    }

    .logo-text h1 {
      font-size: 18px;
      font-weight: 700;
      letter-spacing: 0.5px;
      margin-bottom: 2px;
      color: #1e293b;
    }

    .logo-text p {
      font-size: 12px;
      color: #64748b;
      font-weight: 400;
    }

    /* Success Badge */
    .success-badge {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(90deg, var(--secondary), #0da371);
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 13px;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
      margin-top: 8px;
    }

    .success-badge i {
      margin-right: 8px;
      font-size: 12px;
    }

    /* Profile Section */
    .profile-section {
      padding: 24px;
      display: flex;
      align-items: center;
      border-bottom: 1px solid #e2e8f0;
      background: #f8fafc;
    }

    .profile-avatar {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--accent), #f97316);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 14px;
      font-weight: 700;
      font-size: 20px;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
      border: 2px solid #fff;
      color: white;
    }

    .profile-info h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 4px;
      color: #1e293b;
    }

    .profile-info p {
      font-size: 13px;
      color: #64748b;
      font-weight: 500;
      background: #e0e7ff;
      padding: 4px 10px;
      border-radius: 20px;
      display: inline-block;
    }

    /* Navigation Menu */
    .nav-menu {
      flex: 1;
      padding: 24px 0;
      overflow-y: auto;
    }

    .nav-section {
      margin-bottom: 20px;
    }

    .nav-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.2px;
      color: #94a3b8;
      padding: 16px 24px 8px;
      text-transform: uppercase;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 14px 24px;
      text-decoration: none;
      color: #64748b;
      font-size: 15px;
      font-weight: 500;
      transition: var(--transition);
      position: relative;
      margin: 2px 0;
      border-right: 4px solid transparent;
    }

    .nav-item:hover {
      background: #f1f5f9;
      color: #2563eb;
    }

    .nav-item.active {
      background: #eff6ff;
      color: #2563eb;
      border-right-color: #2563eb;
    }

    .nav-item.active::before {
      display: none;
    }

    .nav-icon {
      width: 22px;
      margin-right: 16px;
      font-size: 18px;
      text-align: center;
      opacity: 0.7;
    }

    .nav-item:hover .nav-icon,
    .nav-item.active .nav-icon {
      opacity: 1;
    }

    .nav-text {
      flex: 1;
    }

    .badge {
      background-color: var(--accent);
      color: var(--dark);
      font-size: 11px;
      padding: 4px 8px;
      border-radius: 10px;
      font-weight: 700;
      min-width: 20px;
      text-align: center;
    }

    /* Alert Animation */
    @keyframes slide-down {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .animate-slide-down {
      animation: slide-down 0.3s ease-out;
    }

    /* Sidebar Footer */
    .sidebar-footer {
      padding: 20px 24px;
      border-top: 1px solid #e2e8f0;
      font-size: 12px;
      color: #94a3b8;
      text-align: center;
      background: #f8fafc;
    }

    .copyright {
      margin-bottom: 8px;
      font-weight: 500;
    }

    .system-name {
      font-weight: 600;
      color: #64748b;
    }

    /* Mobile Toggle Button */
    .mobile-toggle {
      position: fixed;
      top: 24px;
      left: 24px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      border-radius: 12px;
      width: 48px;
      height: 48px;
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 101;
      box-shadow: 0 4px 15px rgba(45, 108, 234, 0.3);
      transition: var(--transition);
    }

    .mobile-toggle:hover {
      transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 1024px) {
      .sidebar {
        position: fixed;
        height: 100vh;
        transform: translateX(-100%);
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.2);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .mobile-toggle {
        display: flex;
      }
    }
      color: white;
      padding-left: 28px;
    }

    .nav-item.active {
      background-color: rgba(45, 140, 255, 0.1);
      color: white;
      border-left-color: var(--sidebar-active);
    }

    .nav-icon {
      width: 20px;
      margin-right: 14px;
      font-size: 16px;
      text-align: center;
      opacity: 0.8;
    }

    .nav-item.active .nav-icon {
      opacity: 1;
    }

    .nav-text {
      flex: 1;
    }

    .sidebar-footer {
      padding: 20px 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 12px;
      color: rgba(255, 255, 255, 0.5);
      text-align: center;
      background: rgba(255, 255, 255, 0.02);
    }

    .copyright {
      margin-bottom: 8px;
      font-weight: 500;
    }

    .system-name {
      font-weight: 600;
      color: rgba(255, 255, 255, 0.7);
    }

    /* Mobile Toggle Button */
    .mobile-toggle {
      position: fixed;
      top: 24px;
      left: 24px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      border-radius: 12px;
      width: 48px;
      height: 48px;
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 101;
      box-shadow: 0 4px 15px rgba(45, 108, 234, 0.3);
      transition: var(--transition);
    }

    .mobile-toggle:hover {
      transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.2);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .mobile-toggle {
        display: flex;
      }

      .flex-1.flex.flex-col {
        margin-left: 0 !important;
      }
    }

    /* Animation for sidebar */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(-10px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .nav-item {
      animation: fadeIn 0.3s ease forwards;
      opacity: 0;
    }

    .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .nav-item:nth-child(2) { animation-delay: 0.15s; }
    .nav-item:nth-child(3) { animation-delay: 0.2s; }
    .nav-item:nth-child(4) { animation-delay: 0.25s; }
    .nav-item:nth-child(5) { animation-delay: 0.3s; }
    .nav-item:nth-child(6) { animation-delay: 0.35s; }
    .nav-item:nth-child(7) { animation-delay: 0.4s; }

    .section-title {
      display: none;
    }

    /* Content Area Styling */
    .main-content {
      font-size: 1rem;
      line-height: 1.6;
    }

    /* Card Standardization */
    .card { 
      border-radius: 12px; 
      background: #ffffff; 
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); 
      border: 1px solid rgba(226, 232, 240, 0.8);
    }
    
    /* Badge Standardization */
    .badge { 
      display: inline-flex;
      align-items: center;
      padding: 4px 12px; 
      border-radius: 20px; 
      font-size: 0.75rem;
      font-weight: 600;
      line-height: 1.5;
    }
    
    /* Button Standardization */
    .btn { 
      display: inline-flex; 
      align-items: center; 
      justify-content: center; 
      font-weight: 600;
      font-size: 0.875rem;
      line-height: 1.5;
      padding: 0.625rem 1.25rem;
      border-radius: 0.5rem; 
      transition: all 0.2s;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-primary { background: #2d6cea; color: #fff; }
    .btn-success { background: #10b981; color: #fff; }
    .btn-danger { background: #dc2626; color: #fff; }

    /* Typography Standardization */
    h1 {
      font-size: 1.5rem;
      font-weight: 700;
      line-height: 1.4;
      color: #0f172a;
    }

    h2 {
      font-size: 1.25rem;
      font-weight: 700;
      line-height: 1.4;
      color: #0f172a;
    }

    h3 {
      font-size: 1.125rem;
      font-weight: 600;
      line-height: 1.4;
      color: #0f172a;
    }

    p, span, div {
      line-height: 1.6;
      font-size: 0.875rem;
    }

    /* Table Standardization */
    table {
      font-size: 0.875rem;
    }

    table th {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      padding: 0.75rem 1.5rem;
    }

    table td {
      padding: 0.75rem 1.5rem;
      font-size: 0.875rem;
    }

    /* Input Standardization */
    input, select, textarea {
      font-size: 0.875rem;
      line-height: 1.5;
    }

    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(45, 108, 234, 0.1);
    }

    /* Focus states for accessibility */
    a:focus, button:focus {
      outline: 2px solid var(--primary);
      outline-offset: 2px;
    }

    /* Stat Card Responsive */
    .stat-card {
      min-height: 140px;
    }

    .stat-card .text-6xl,
    .stat-card .text-5xl {
      font-size: 2.5rem;
      line-height: 1.2;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      html {
        font-size: 14px;
      }

      h1 {
        font-size: 1.375rem;
      }

      h2 {
        font-size: 1.125rem;
      }

      .stat-card .text-6xl,
      .stat-card .text-5xl {
        font-size: 2rem;
      }
    }
  </style>
  <title>Hotel Nuansa - Sistem Manajemen Hotel</title>
</head>
<body>

  <!-- Mobile Toggle Button -->
  <button class="mobile-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>

  <div class="flex h-screen w-full bg-slate-50 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-white border-r border-slate-200 text-slate-600 transition-all duration-300 sidebar hidden md:flex flex-col shadow-sm" id="sidebar" style="position: fixed; left: 0; top: 0; height: 100vh;">
      <div class="sidebar-header">
        <div class="logo-container">
          <div class="logo-icon">
            <i class="fas fa-hotel"></i>
          </div>
          <div class="logo-text">
            <h1>HOTEL NUANSA</h1>
            <p>Sistem Manajemen Hotel</p>
          </div>
        </div>
      </div>

      <div class="nav-menu">
        @auth
          @if(auth()->check() && auth()->user()->role === 'kasir')
            <div class="nav-section">
              <div class="nav-title">Menu Utama</div>
              <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-house"></i>
                </div>
                <div class="nav-text">Beranda</div>
              </a>
              
              <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="nav-text">Riwayat</div>
                @if(\App\Models\Transaction::where('status', 'active')->count() > 0)
                  <div class="badge">{{ \App\Models\Transaction::where('status', 'active')->count() }}</div>
                @endif
              </a>

              <a href="{{ route('rooms.index') }}" class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-door-open"></i>
                </div>
                <div class="nav-text">Kamar</div>
              </a>

              <a href="{{ route('recaps.personal') }}" class="nav-item {{ request()->routeIs('recaps.personal') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="nav-text">Shift Saya</div>
              </a>
            </div>
          @endif

          @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="nav-section">
              <div class="nav-title">Menu Utama</div>
              <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-home"></i>
                </div>
                <div class="nav-text">Beranda</div>
              </a>

              <a href="{{ route('rooms.index') }}" class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-bed"></i>
                </div>
                <div class="nav-text">Kamar</div>
                <div class="badge">{{ \App\Models\Room::count() }}</div>
              </a>

              <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="nav-text">Riwayat</div>
                @if(\App\Models\Transaction::whereNull('check_out')->count() > 0)
                  <div class="badge">{{ \App\Models\Transaction::whereNull('check_out')->count() }}</div>
                @endif
              </a>
            </div>

            <div class="nav-section">
              <div class="nav-title">Manajemen</div>
              <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-users"></i>
                </div>
                <div class="nav-text">User</div>
                <div class="badge">{{ \App\Models\User::count() }}</div>
              </a>
              
              <a href="{{ route('expenses.index') }}" class="nav-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="nav-text">Pengeluaran</div>
              </a>

              <a href="{{ route('reports.finance') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-chart-bar"></i>
                </div>
                <div class="nav-text">Laporan</div>
              </a>

              <a href="{{ route('recaps.daily') }}" class="nav-item {{ request()->routeIs('recaps.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-calendar-day"></i>
                </div>
                <div class="nav-text">Rekap Harian</div>
              </a>
            </div>
          @endif
        @endauth
      </div>


      <div class="sidebar-footer">
        <div class="copyright">© 2026 Hotel Nuansa</div>
        <div class="system-name">Sistem Manajemen Hotel</div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen w-full relative" style="margin-left: 256px;">
      <!-- Header -->
      <header class="w-full h-16 bg-white shadow-sm flex items-center justify-between px-6" style="flex-shrink: 0;">
        <div class="flex items-center gap-4 flex-1">
          <button id="sidebar-toggle" class="md:hidden text-gray-700 hover:text-gray-900 p-2">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
        
        <!-- Right Section: Date + Profile Widget -->
        <div class="flex items-center gap-8">
          <!-- Date Display -->
          <div class="hidden lg:flex flex-col items-end min-w-[160px]">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ now()->isoFormat('dddd') }}</p>
            <p class="text-base font-bold text-slate-800 mt-1">{{ now()->isoFormat('D MMMM YYYY') }}</p>
          </div>

          @auth
          <!-- Profile User Pill -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-5 hover:bg-slate-100/80 px-5 py-3 rounded-xl transition-all border border-slate-200 hover:border-slate-300 shadow-sm hover:shadow-md min-w-[200px]">
              <!-- Avatar Circle with Ring -->
              <img 
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff&size=128" 
                class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-lg ring-2 ring-slate-100" 
                alt="{{ auth()->user()->name }}">
              
              <!-- User Info (Hidden on Mobile) -->
              <div class="hidden md:block text-left flex-1">
                <p class="text-base font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold mt-1.5">{{ auth()->user()->role }}</p>
              </div>

              <!-- Chevron Down Icon -->
              <svg class="hidden md:block w-5 h-5 text-slate-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
              x-show="open" 
              @click.away="open = false"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 scale-95"
              x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-150"
              x-transition:leave-start="opacity-100 scale-100"
              x-transition:leave-end="opacity-0 scale-95"
              class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50"
              style="display: none;">
              
              <!-- User Info (Mobile) -->
              <div class="px-4 py-3 border-b border-slate-100">
                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->email ?? 'admin@hotelnuansa.com' }}</p>
              </div>

              <!-- Logout -->
              <div class="border-t border-slate-100 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors font-semibold">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Keluar</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
          @endauth
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
          <!-- Session Alerts with Auto-hide -->
          @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="p-5 bg-emerald-50 border-2 border-emerald-200 text-emerald-800 rounded-2xl flex items-start gap-4 mb-6 shadow-lg animate-slide-down">
              <i class="fas fa-check-circle flex-shrink-0 text-2xl text-emerald-600"></i>
              <div class="flex-1">
                <h4 class="font-bold text-base mb-1">Berhasil!</h4>
                <p class="text-sm font-medium">{{ session('success') }}</p>
              </div>
              <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 transition">
                <i class="fas fa-times"></i>
              </button>
            </div>
          @endif
          @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" class="p-5 bg-rose-50 border-2 border-rose-200 text-rose-800 rounded-2xl flex items-start gap-4 mb-6 shadow-lg animate-slide-down">
              <i class="fas fa-exclamation-circle flex-shrink-0 text-2xl text-rose-600"></i>
              <div class="flex-1">
                <h4 class="font-bold text-base mb-1">Terjadi Kesalahan!</h4>
                <p class="text-sm font-medium">{{ session('error') }}</p>
              </div>
              <button @click="show = false" class="text-rose-600 hover:text-rose-800 transition">
                <i class="fas fa-times"></i>
              </button>
            </div>
          @endif
          @if(session('info'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="p-5 bg-blue-50 border-2 border-blue-200 text-blue-800 rounded-2xl flex items-start gap-4 mb-6 shadow-lg animate-slide-down">
              <i class="fas fa-info-circle flex-shrink-0 text-2xl text-blue-600"></i>
              <div class="flex-1">
                <h4 class="font-bold text-base mb-1">Informasi</h4>
                <p class="text-sm font-medium">{{ session('info') }}</p>
              </div>
              <button @click="show = false" class="text-blue-600 hover:text-blue-800 transition">
                <i class="fas fa-times"></i>
              </button>
            </div>
          @endif

          <!-- Page Content -->
          @yield('content')
      </main>
    </div>
  </div>

  <!-- Confirmation Modal (Reusable) -->
  <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all scale-95" id="confirmModalContent">
      <div class="p-6 border-b border-slate-200">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-question-circle text-3xl text-blue-600"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-slate-800" id="confirmModalTitle">Konfirmasi Tindakan</h3>
            <p class="text-sm text-slate-500 mt-1">Pastikan data sudah benar</p>
          </div>
        </div>
      </div>
      
      <div class="p-6">
        <p class="text-slate-700 text-base leading-relaxed" id="confirmModalMessage">
          Apakah Anda yakin ingin melanjutkan tindakan ini?
        </p>
      </div>
      
      <div class="p-6 bg-slate-50 rounded-b-2xl flex gap-3">
        <button type="button" onclick="closeConfirmModal()" class="flex-1 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl transition-all">
          <i class="fas fa-times mr-2"></i>Tidak, Batal
        </button>
        <button type="button" id="confirmModalYes" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all shadow-lg">
          <i class="fas fa-check mr-2"></i>Ya, Lanjutkan
        </button>
      </div>
    </div>
  </div>

  <script>
    // Confirmation Modal Functions
    let pendingFormSubmit = null;
    
    function showConfirmModal(title, message, onConfirm) {
      document.getElementById('confirmModalTitle').textContent = title;
      document.getElementById('confirmModalMessage').textContent = message;
      document.getElementById('confirmModal').classList.remove('hidden');
      document.getElementById('confirmModalContent').classList.add('scale-100');
      document.getElementById('confirmModalContent').classList.remove('scale-95');
      
      // Set confirm action
      document.getElementById('confirmModalYes').onclick = function() {
        closeConfirmModal();
        if (onConfirm) onConfirm();
      };
    }
    
    function closeConfirmModal() {
      document.getElementById('confirmModalContent').classList.add('scale-95');
      document.getElementById('confirmModalContent').classList.remove('scale-100');
      setTimeout(() => {
        document.getElementById('confirmModal').classList.add('hidden');
      }, 200);
    }
    
    // Close modal when clicking outside
    document.getElementById('confirmModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeConfirmModal();
      }
    });
    
    // Auto-attach confirmation to forms with class "confirm-form"
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.confirm-form').forEach(form => {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          const title = this.dataset.confirmTitle || 'Konfirmasi Tindakan';
          const message = this.dataset.confirmMessage || 'Apakah Anda yakin data sudah benar dan ingin melanjutkan?';
          
          showConfirmModal(title, message, () => {
            this.submit();
          });
        });
      });
      
      // Auto-attach to buttons with class "confirm-button"
      document.querySelectorAll('.confirm-button').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const title = this.dataset.confirmTitle || 'Konfirmasi Tindakan';
          const message = this.dataset.confirmMessage || 'Apakah Anda yakin ingin melanjutkan?';
          const href = this.getAttribute('href');
          
          showConfirmModal(title, message, () => {
            if (href) window.location.href = href;
          });
        });
      });
    });

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const oldToggle = document.getElementById('sidebar-toggle');
    
    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        
        // Change toggle icon
        const icon = sidebarToggle.querySelector('i');
        if (sidebar.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });
      
      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', (e) => {
        if (window.innerWidth <= 1024 && 
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target)) {
          sidebar.classList.remove('active');
          sidebarToggle.querySelector('i').classList.remove('fa-times');
          sidebarToggle.querySelector('i').classList.add('fa-bars');
        }
      });
      
      // Window resize handler
      window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) {
          sidebar.classList.remove('active');
          sidebarToggle.querySelector('i').classList.remove('fa-times');
          sidebarToggle.querySelector('i').classList.add('fa-bars');
        }
      });
    }
    
    // Old toggle for compatibility
    if (oldToggle && sidebar) {
      oldToggle.addEventListener('click', function() {
        sidebar.classList.toggle('hidden');
      });
    }
    
    // Auto-print struk after checkout
    @if(session('print_struk'))
      window.open('{{ session('print_struk') }}', '_blank');
    @endif
    
    // Auto-open struk in new tab after checkout (with popup blocker detection)
    @if(session('open_struk'))
      setTimeout(function() {
        const strukWindow = window.open('{{ session('open_struk') }}', '_blank');
        
        // Check if popup was blocked
        if (!strukWindow || strukWindow.closed || typeof strukWindow.closed === 'undefined') {
          // Popup was blocked, show notification with manual button
          const notification = document.createElement('div');
          notification.innerHTML = `
            <div style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 9999; background: white; padding: 20px 30px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); max-width: 500px; text-align: center; border: 3px solid #3b82f6;">
              <div style="font-size: 18px; font-weight: bold; color: #1e293b; margin-bottom: 12px;">
                <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 8px;"></i>
                Popup Diblokir Browser
              </div>
              <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;">
                Browser memblokir pembukaan struk otomatis. Klik tombol di bawah untuk membuka struk:
              </p>
              <a href="{{ session('open_struk') }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 16px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">
                <i class="fas fa-receipt" style="margin-right: 8px;"></i>
                Buka Struk Sekarang
              </a>
              <button onclick="this.parentElement.remove()" style="display: block; margin: 15px auto 0; background: transparent; border: none; color: #94a3b8; cursor: pointer; font-size: 13px; text-decoration: underline;">
                Tutup
              </button>
            </div>
          `;
          document.body.appendChild(notification);
        }
      }, 500);
    @endif
  </script>

</body>
</html>
