<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Hotel Nuansa - Front Office')</title>

  <!-- Google Fonts: Plus Jakarta Sans & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS & FontAwesome -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
          colors: {
            nuansa: {
              bg: '#F5EFE6',         // Warm linen / cream background
              card: '#FFFFFF',
              navy: '#0B192C',       // Sidebar midnight navy
              navyLight: '#132A4A',
              navyDark: '#07101C',
              amber: '#F5A623',      // Active pill / badge golden amber
              amberLight: '#F6BA55',
              amberDark: '#D98200',
              blue: '#1D58B8',       // Royal blue stat card
              blueLight: '#2B72E2',
            }
          }
        }
      }
    }
  </script>

  <style>
    * {
      font-family: 'Plus Jakarta Sans', Inter, sans-serif;
    }
    body {
      background-color: #F5EFE6;
      color: #0B192C;
      overflow-x: hidden;
    }
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #F5EFE6;
    }
    ::-webkit-scrollbar-thumb {
      background: #CBD5E1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94A3B8;
    }
    .custom-shadow {
      box-shadow: 0 4px 20px -2px rgba(11, 25, 44, 0.05);
    }
    .custom-shadow-lg {
      box-shadow: 0 10px 30px -4px rgba(11, 25, 44, 0.08);
    }
    @keyframes pulseDot {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.3); opacity: 0.6; }
    }
    .animate-pulse-dot {
      animation: pulseDot 2s infinite ease-in-out;
    }
  </style>
  @stack('styles')
</head>
<body class="min-h-screen bg-[#F5EFE6] text-[#0B192C] flex antialiased" x-data="{ sidebarOpen: false }">

  <!-- Mobile Overlay -->
  <div x-show="sidebarOpen" 
       x-transition:enter="transition-opacity ease-linear duration-200" 
       x-transition:enter-start="opacity-0" 
       x-transition:enter-end="opacity-100" 
       x-transition:leave="transition-opacity ease-linear duration-200" 
       x-transition:leave-start="opacity-100" 
       x-transition:leave-end="opacity-0" 
       @click="sidebarOpen = false" 
       class="fixed inset-0 bg-black/50 z-40 md:hidden" 
       style="display: none;"></div>

  <!-- SIDEBAR -->
  <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
         class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0B192C] text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out shadow-2xl md:shadow-none">
    
    <!-- Top Brand & Navigation -->
    <div class="p-5 flex flex-col h-full">
      
      <!-- Brand Logo -->
      <div class="flex items-center gap-3.5 mb-8 px-1">
        <div class="w-10 h-10 rounded-xl bg-[#F5A623] text-[#0B192C] font-extrabold text-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
          N
        </div>
        <div>
          <h1 class="text-white font-bold text-base leading-tight tracking-wide">Hotel Nuansa</h1>
          <p class="text-slate-400 text-xs font-medium tracking-wider">Front Office</p>
        </div>
      </div>

      <!-- Navigation Links -->
      <nav class="space-y-1.5 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('dashboard*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-home text-base w-5 text-center"></i>
          <span>Dashboard</span>
        </a>

        <!-- Check-in (Front Office) -->
        <a href="{{ route('checkin') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('checkin*') || request()->routeIs('front-office*') || request()->routeIs('transactions.create*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-key text-base w-5 text-center"></i>
          <span>Check-in</span>
        </a>

        <!-- Riwayat Transaksi -->
        <a href="{{ route('transactions.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') || request()->routeIs('transactions.guestBook') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-receipt text-base w-5 text-center"></i>
          <span>Riwayat Transaksi</span>
        </a>

        <!-- Kamar -->
        <a href="{{ route('rooms.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('rooms*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-bed text-base w-5 text-center"></i>
          <span>Kamar</span>
        </a>

        <!-- Pengeluaran -->
        <a href="{{ route('expenses.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('expenses*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-wallet text-base w-5 text-center"></i>
          <span>Pengeluaran</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('reports.finance') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('reports*') || request()->routeIs('recaps*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-chart-simple text-base w-5 text-center"></i>
          <span>Laporan</span>
        </a>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Pengguna (Admin Only) -->
        <a href="{{ route('users.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('users*') ? 'bg-[#F5A623] text-[#0B192C] shadow-md shadow-amber-500/20 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
          <i class="fas fa-user-gear text-base w-5 text-center"></i>
          <span>Pengguna</span>
        </a>
        @endif
      </nav>

      <!-- Bottom Shift Information Card -->
      @php
        $now = \Carbon\Carbon::now();
        $isMorning = ($now->hour >= 7 && $now->hour < 19);
        $shiftName = $isMorning ? 'Shift Pagi' : 'Shift Malam';
        $shiftTime = $isMorning ? '07:00–19:00' : '19:00–07:00';
      @endphp
      <div class="mt-auto pt-4">
        <div class="bg-[#071322] border border-white/5 rounded-2xl p-4 shadow-inner">
          <div class="text-[#F5A623] font-bold text-xs uppercase tracking-wider mb-1">
            {{ $shiftName }}
          </div>
          <div class="text-white text-xs font-semibold mb-1">
            {{ $shiftTime }}
          </div>
          <div class="text-slate-400 text-xs truncate">
            Kasir: {{ auth()->check() ? auth()->user()->name : 'Admin' }}
          </div>
        </div>
      </div>

    </div>
  </aside>

  <!-- MAIN VIEWPORT WRAPPER -->
  <div class="flex-1 flex flex-col min-h-screen md:pl-64 transition-all duration-300">
    
    <!-- TOP HEADER -->
    <header class="sticky top-0 z-30 bg-[#F5EFE6]/95 backdrop-blur-md px-6 md:px-10 py-5 flex items-center justify-between border-b border-stone-200/50">
      
      <!-- Left: Mobile Toggle + Page Title & Date -->
      <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-[#0B192C] p-2 hover:bg-stone-200/60 rounded-xl transition-all">
          <i class="fas fa-bars text-xl"></i>
        </button>

        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-[#0B192C] tracking-tight">
            @yield('page_title', 'Dashboard')
          </h1>
          <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">
            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
          </p>
        </div>
      </div>

      <!-- Right: User Initial Avatar Dropdown -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" 
                class="w-11 h-11 rounded-full bg-[#0B192C] text-white font-bold text-base flex items-center justify-center hover:ring-4 hover:ring-amber-500/20 transition-all shadow-md">
          {{ strtoupper(substr(auth()->check() ? auth()->user()->name : 'A', 0, 1)) }}
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" 
             @click.away="open = false" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-stone-200 p-2 z-50"
             style="display: none;">
          
          <div class="px-4 py-3 border-b border-stone-100">
            <p class="text-sm font-bold text-[#0B192C] truncate">{{ auth()->user()->name ?? 'User' }}</p>
            <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role ?? 'Kasir' }} • {{ auth()->user()->phone ?? '' }}</p>
          </div>

          <a href="{{ route('recaps.personal') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-stone-50 rounded-xl transition-all">
            <i class="fas fa-receipt text-slate-400 w-4 text-center"></i>
            <span>Shift Saya</span>
          </a>

          <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 rounded-xl transition-all font-semibold text-left">
              <i class="fas fa-arrow-right-from-bracket text-rose-500 w-4 text-center"></i>
              <span>Logout</span>
            </button>
          </form>
        </div>
      </div>

    </header>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
      <div class="mx-6 md:mx-10 mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm" x-data="{ show: true }" x-show="show">
        <div class="flex items-center gap-3">
          <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
          <span>{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1">
          <i class="fas fa-times"></i>
        </button>
      </div>
    @endif

    @if(session('error'))
      <div class="mx-6 md:mx-10 mt-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm" x-data="{ show: true }" x-show="show">
        <div class="flex items-center gap-3">
          <i class="fas fa-exclamation-triangle text-rose-600 text-lg"></i>
          <span>{{ session('error') }}</span>
        </div>
        <button @click="show = false" class="text-rose-500 hover:text-rose-700 p-1">
          <i class="fas fa-times"></i>
        </button>
      </div>
    @endif

    <!-- MAIN PAGE CONTENT -->
    <main class="flex-1 px-6 md:px-10 py-6">
      @yield('content')
    </main>

  </div>

  @if(session('open_struk'))
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        window.open("{{ session('open_struk') }}", '_blank');
      });
    </script>
  @endif

  @stack('scripts')
</body>
</html>
