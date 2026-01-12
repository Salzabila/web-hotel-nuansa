<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
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

      @auth
        <div class="profile-section">
          <div class="profile-avatar">
            {{ substr(auth()->user()->name, 0, 1) }}
          </div>
          <div class="profile-info">
            <h3>{{ auth()->user()->name }}</h3>
            <p>{{ ucfirst(auth()->user()->role) }}</p>
          </div>
        </div>
      @endauth

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

              <a href="{{ route('rooms.index') }}" class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-bed"></i>
                </div>
                <div class="nav-text">Kamar</div>
              </a>
              
              <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="nav-text">Transaksi</div>
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
                <div class="nav-text">Transaksi</div>
                @if(\App\Models\Transaction::whereNull('check_out')->count() > 0)
                  <div class="badge">{{ \App\Models\Transaction::whereNull('check_out')->count() }}</div>
                @endif
              </a>
            </div>

            <div class="nav-section">
              <div class="nav-title">Manajemen</div>
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

              <a href="{{ route('feedbacks.index') }}" class="nav-item {{ request()->routeIs('feedbacks.*') ? 'active' : '' }}">
                <div class="nav-icon">
                  <i class="fas fa-comment-alt"></i>
                </div>
                <div class="nav-text">Feedback</div>
                @if(\App\Models\Feedback::count() > 0)
                  <div class="badge">{{ \App\Models\Feedback::count() }}</div>
                @endif
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
          <div class="hidden sm:block">
            <h2 class="text-base font-semibold text-gray-900">Selamat Datang</h2>
            @auth
              <p class="text-sm font-medium text-gray-600">{{ auth()->user()->name }} · <span class="text-blue-600 uppercase text-xs font-bold">{{ auth()->user()->role }}</span></p>
            @endauth
          </div>
        </div>
        <div class="flex items-center gap-4">
          <div class="hidden md:block text-right">
            <p class="text-xs font-medium text-gray-500">{{ now()->isoFormat('dddd') }}</p>
            <p class="text-sm font-semibold text-gray-900">{{ now()->isoFormat('D MMMM YYYY') }}</p>
          </div>
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
            @auth
              {{ substr(auth()->user()->name, 0, 1) }}
            @endauth
          </div>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
          <!-- Session Alerts -->
          @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-start gap-3 mb-6 shadow-sm">
              <i class="fas fa-check-circle flex-shrink-0 text-lg mt-0.5 text-emerald-600"></i>
              <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
          @endif
          @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-start gap-3 mb-6 shadow-sm">
              <i class="fas fa-exclamation-circle flex-shrink-0 text-lg mt-0.5 text-rose-600"></i>
              <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
          @endif
          @if(session('info'))
            <div class="p-3 bg-blue-50 border-l-4 border-blue-500 text-blue-800 rounded-lg flex items-start gap-2 mb-4">
              <i class="fas fa-info-circle flex-shrink-0 text-lg mt-0.5"></i>
              <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
          @endif

          <!-- Page Content -->
          @yield('content')
      </main>
    </div>
  </div>

  <script>
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
  </script>

</body>
</html>
