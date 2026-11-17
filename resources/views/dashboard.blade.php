@extends('layouts.app')

@section('title', 'Dashboard - Hotel Nuansa')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

  @php
    $overdueGuestsList = ($approachingCheckoutGuests ?? collect())->filter(fn($g) => $g->checkout_urgency === 'overdue');
  @endphp

  <!-- POPUP PERINGATAN TERLAMBAT CHECKOUT -->
  @if($overdueGuestsList->isNotEmpty())
    <div id="overdueCheckoutModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border-2 border-rose-500 overflow-hidden animate-in fade-in zoom-in duration-200">
        
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-rose-600 via-rose-500 to-amber-500 p-6 text-white flex items-start justify-between gap-4">
          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-xs flex items-center justify-center text-2xl shrink-0 shadow-inner">
              <i class="fas fa-bell text-white animate-bounce"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <span class="bg-white/25 text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">Perhatian Kasir & Front Office</span>
              </div>
              <h3 class="text-lg md:text-xl font-extrabold text-white mt-1">
                Peringatan Checkout Terlambat!
              </h3>
              <p class="text-xs text-rose-100 mt-0.5">
                Terdapat <strong>{{ $overdueGuestsList->count() }} kamar</strong> yang sudah melewati batas waktu checkout (12:00 WIB).
              </p>
            </div>
          </div>
          <button type="button" onclick="closeOverdueModal()" class="w-8 h-8 rounded-full bg-black/20 hover:bg-black/30 flex items-center justify-center text-white/80 hover:text-white transition-all shrink-0">
            <i class="fas fa-times text-sm"></i>
          </button>
        </div>

        <!-- Body: Daftar Kamar Terlambat -->
        <div class="p-6 max-h-[60vh] overflow-y-auto space-y-3 bg-slate-50/50">
          @foreach($overdueGuestsList as $overdue)
            <div class="bg-white p-4 rounded-2xl border border-rose-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-rose-400 transition-all">
              <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-rose-100 text-rose-700 font-extrabold flex flex-col items-center justify-center shrink-0 border border-rose-300">
                  <span class="text-[9px] uppercase tracking-tighter">Kamar</span>
                  <span class="text-base font-black leading-none">{{ $overdue->room->room_number }}</span>
                </div>
                <div>
                  <h5 class="text-sm font-bold text-slate-800">{{ $overdue->guest_name }}</h5>
                  <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500">
                    <span>{{ $overdue->room->type }}</span>
                    <span>•</span>
                    <span class="text-rose-600 font-bold flex items-center gap-1">
                      <i class="fas fa-clock text-[10px]"></i> {{ $overdue->checkout_countdown_text }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Tombol Aksi Langsung -->
              <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="openCheckoutModal({{ $overdue->id }}); closeOverdueModal();" 
                        class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-xs transition-all active:scale-95 flex items-center gap-1.5">
                  <i class="fas fa-arrow-right-from-bracket text-[11px]"></i>
                  <span>Checkout</span>
                </button>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Footer Modal -->
        <div class="p-4 bg-white border-t border-slate-100 flex items-center justify-between gap-3">
          <span class="text-xs text-slate-400 italic">Harap konfirmasi ke tamu terkait overtime/extend stay.</span>
          <button type="button" onclick="closeOverdueModal()" 
                  class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all active:scale-95">
            Tutup Peringatan
          </button>
        </div>

      </div>
    </div>
  @endif

  <!-- HERO BANNER -->
  <div class="relative overflow-hidden rounded-3xl p-7 md:p-9 text-white shadow-xl"
       style="background: linear-gradient(135deg, #09172B 0%, #0F2A52 50%, #1A4482 100%);">
    
    <!-- Decorative background curves -->
    <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-blue-500/10 blur-2xl pointer-events-none"></div>
    <div class="absolute right-40 -top-20 w-60 h-60 rounded-full bg-amber-400/10 blur-xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
      <!-- Left Greeting & Actions -->
      <div class="max-w-xl">
        <p class="text-slate-300 text-xs md:text-sm font-semibold tracking-wide mb-1.5">
          Selamat pagi, {{ auth()->user()->name }}
        </p>
        <h2 class="text-2xl md:text-4xl font-extrabold tracking-tight leading-snug mb-6">
          Okupansi hari ini sedang berjalan baik
        </h2>
        <div class="flex items-center gap-3.5">
          <a href="{{ route('checkin') }}" 
             class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-sm shadow-md transition-all hover:scale-105 active:scale-95">
            Check-in Baru
          </a>
          <a href="{{ route('reports.finance') }}" 
             class="border border-white/40 hover:bg-white/10 hover:border-white text-white font-semibold px-6 py-2.5 rounded-full text-sm transition-all">
            Lihat Laporan
          </a>
        </div>
      </div>

      <!-- Right Donut & Room Count Gauge -->
      <div class="flex items-center gap-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 self-start md:self-auto">
        <!-- SVG Donut Chart -->
        <div class="relative w-24 h-24 flex items-center justify-center">
          <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
            <!-- Background circle track -->
            <circle cx="50" cy="50" r="38" stroke="#1E3A68" stroke-width="9" fill="transparent" />
            <!-- Progress circle -->
            @php
              $circumference = 2 * 3.14159 * 38;
              $dashoffset = $circumference - ($circumference * ($occupancyRate ?? 0) / 100);
            @endphp
            <circle cx="50" cy="50" r="38" stroke="#F5A623" stroke-width="9" stroke-linecap="round"
                    stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $dashoffset }}"
                    fill="transparent" style="transition: stroke-dashoffset 1s ease-in-out;" />
          </svg>
          <div class="absolute inset-0 flex items-center justify-center text-center">
            <span class="text-white font-black text-lg md:text-xl">{{ $occupancyRate ?? 0 }}%</span>
          </div>
        </div>

        <!-- Legend Numbers -->
        <div class="space-y-1.5 text-xs md:text-sm">
          <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
            <span class="text-slate-200">Terisi: <strong class="text-white font-bold">{{ $occupiedRooms ?? 0 }}</strong> kamar</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
            <span class="text-slate-200">Tersedia: <strong class="text-white font-bold">{{ $availableRooms ?? 0 }}</strong> kamar</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
            <span class="text-slate-200">Kotor: <strong class="text-white font-bold">{{ $dirtyRooms ?? 0 }}</strong> kamar</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- WARNING BANNER: INCOMPLETE GUEST DATA -->
  @if(($incompleteGuestsCount ?? 0) > 0)
    <div class="bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-amber-500/5 border-2 border-amber-400 rounded-3xl p-5 md:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-start sm:items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-[#F5A623] text-[#0B192C] flex items-center justify-center shrink-0 shadow-md">
          <i class="fas fa-exclamation-triangle text-xl animate-pulse"></i>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h4 class="text-sm md:text-base font-extrabold text-[#0B192C]">
              Perhatian: Ada {{ $incompleteGuestsCount }} Tamu Belum Melengkapi Identitas!
            </h4>
            <span class="bg-rose-500 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Express Check-in
            </span>
          </div>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            Terdapat tamu aktif dengan data NIK & identitas belum lengkap. Harap segera lengkapi di Front Office agar tertib administrasi hotel.
          </p>
        </div>
      </div>
      <a href="{{ route('front-office') }}#buku-tamu-section" 
         class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold text-xs px-6 py-3 rounded-full shadow-md transition-all active:scale-95 whitespace-nowrap self-start md:self-auto flex items-center gap-2">
        <i class="fas fa-user-edit"></i>
        <span>Lengkapi di Front Office</span>
      </a>
    </div>
  @endif

  <!-- WARNING BANNER: APPROACHING / OVERDUE CHECKOUT -->
  @if(($approachingCheckoutCount ?? 0) > 0)
    <div class="bg-gradient-to-r from-rose-500/15 via-amber-500/10 to-transparent border-2 border-rose-400 rounded-3xl p-5 md:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-start sm:items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-md">
          <i class="fas fa-bell text-xl animate-bounce"></i>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h4 class="text-sm md:text-base font-extrabold text-[#0B192C]">
              Peringatan Checkout: Ada {{ $approachingCheckoutCount }} Kamar Mendekati / Melewati Waktu Checkout!
            </h4>
            <span class="bg-rose-600 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Batas 12:00
            </span>
          </div>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            @php
              $overdueList = $approachingCheckoutGuests->filter(fn($g) => $g->checkout_urgency === 'overdue');
              $imminentList = $approachingCheckoutGuests->filter(fn($g) => $g->checkout_urgency === 'imminent');
            @endphp
            @if($overdueList->isNotEmpty())
              <strong class="text-rose-600">{{ $overdueList->count() }} kamar sudah melewati jam 12:00:</strong> Kamar {{ $overdueList->map(fn($g) => $g->room->room_number)->join(', ') }}.
            @endif
            @if($imminentList->isNotEmpty())
              <span class="text-amber-800 font-semibold">{{ $imminentList->count() }} kamar sisa waktu < 2 jam: Kamar {{ $imminentList->map(fn($g) => $g->room->room_number)->join(', ') }}.</span>
            @endif
            Harap segera hubungi tamu atau proses checkout / extend stay di Front Office.
          </p>
        </div>
      </div>
      <a href="{{ route('front-office') }}" 
         class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs px-6 py-3 rounded-full shadow-md transition-all active:scale-95 whitespace-nowrap self-start md:self-auto flex items-center gap-2">
        <i class="fas fa-arrow-right-from-bracket"></i>
        <span>Buka Front Office</span>
      </a>
    </div>
  @endif

  <!-- 4 STAT CARDS ROW -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
    
    <!-- Card 1: Total Pendapatan (Solid Royal Blue) -->
    <div class="bg-[#1D58B8] text-white rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[140px]">
      <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white mb-3">
        <i class="fas fa-arrow-trend-up text-sm"></i>
      </div>
      <div>
        <p class="text-blue-100 text-xs font-semibold">Total Pendapatan</p>
        <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight mt-1 mb-0.5">
          Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}
        </h3>
        <p class="text-blue-200 text-xs font-medium">Bulan ini</p>
      </div>
    </div>

    <!-- Card 2: Total Pengeluaran (White Card) -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between min-h-[140px]">
      <div class="w-9 h-9 rounded-xl bg-stone-100 flex items-center justify-center text-slate-600 mb-3">
        <i class="fas fa-wallet text-sm"></i>
      </div>
      <div>
        <p class="text-slate-500 text-xs font-semibold">Total Pengeluaran</p>
        <h3 class="text-2xl md:text-3xl font-extrabold text-[#0B192C] tracking-tight mt-1 mb-0.5">
          Rp {{ number_format($monthlyExpenses ?? 0, 0, ',', '.') }}
        </h3>
        <p class="text-slate-400 text-xs font-medium">Bulan ini</p>
      </div>
    </div>

    <!-- Card 3: Komisi TC (White Card) -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between min-h-[140px]">
      <div class="w-9 h-9 rounded-xl bg-stone-100 flex items-center justify-center text-slate-600 mb-3">
        <i class="fas fa-user-tag text-sm"></i>
      </div>
      <div>
        <p class="text-slate-500 text-xs font-semibold">Komisi TC</p>
        <h3 class="text-2xl md:text-3xl font-extrabold text-[#0B192C] tracking-tight mt-1 mb-0.5">
          Rp {{ number_format($monthlyTCCommission ?? 0, 0, ',', '.') }}
        </h3>
        <p class="text-slate-400 text-xs font-medium">Bulan ini</p>
      </div>
    </div>

    <!-- Card 4: Estimasi Laba Bersih (Golden Amber) -->
    <div class="bg-[#F6BA55] text-[#0B192C] rounded-3xl p-6 shadow-sm flex flex-col justify-between min-h-[140px]">
      <div class="w-9 h-9 rounded-xl bg-black/10 flex items-center justify-center text-[#0B192C] mb-3">
        <i class="fas fa-coins text-sm"></i>
      </div>
      <div>
        <p class="text-stone-800 text-xs font-bold">Estimasi Laba Bersih</p>
        <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight mt-1 mb-0.5">
          Rp {{ number_format($monthlyProfit ?? 0, 0, ',', '.') }}
        </h3>
        <p class="text-stone-700 text-xs font-semibold">Auto-update</p>
      </div>
    </div>

  </div>

  <!-- MIDDLE ROW: TREN PENDAPATAN + TAMU MENGINAP AKTIF -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- LEFT: Tren Pendapatan 7 Hari (Col 7) -->
    <div class="lg:col-span-7 bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between">
      <div>
        <h3 class="text-base font-bold text-[#0B192C] mb-6">Tren Pendapatan 7 Hari</h3>
        
        @php
          $maxRevenue = (!empty($chartData) && max($chartData) > 0) ? max($chartData) : 100000;
        @endphp

        <!-- Bar Chart Container -->
        <div class="h-56 flex items-end justify-between gap-3 px-2 pt-6 pb-2">
          @foreach($chartLabels as $idx => $label)
            @php
              $val = $chartData[$idx] ?? 0;
              $heightPercent = $maxRevenue > 0 ? max(12, round(($val / $maxRevenue) * 100)) : 12;
              $isHighest = ($val == $maxRevenue && $val > 0);
            @endphp
            <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
              <!-- Tooltip on hover -->
              <div class="absolute -top-10 opacity-0 group-hover:opacity-100 transition-opacity bg-[#0B192C] text-white text-[11px] font-bold py-1 px-2.5 rounded-lg pointer-events-none whitespace-nowrap shadow-lg z-20">
                Rp {{ number_format($val, 0, ',', '.') }}
              </div>
              
              <!-- Bar -->
              <div class="w-full max-w-[42px] rounded-t-xl transition-all duration-300 group-hover:scale-105 {{ $isHighest ? 'bg-[#F5A623] shadow-md shadow-amber-500/20' : 'bg-[#183A76] hover:bg-[#1E4B99]' }}"
                   style="height: {{ $heightPercent }}%;"></div>
              
              <!-- Day Label -->
              <span class="text-xs font-semibold text-slate-500 mt-3">{{ $label }}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- RIGHT: Tamu Menginap Aktif (Col 5) -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-[#0B192C]">Tamu Menginap Aktif</h3>
        <span class="text-xs font-bold text-slate-400">{{ count($activeTransactionsList ?? []) }} Tamu</span>
      </div>

      <div class="space-y-3 flex-1 overflow-y-auto max-h-[260px] pr-1">
        @forelse($activeTransactionsList ?? [] as $tx)
          <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8F5EF] hover:bg-[#F2ECE1] transition-all cursor-pointer"
               onclick="openCheckoutModal({{ $tx->id }})">
            <div>
              <div class="flex items-center gap-2">
                <p class="text-sm font-bold text-[#0B192C]">Kamar {{ $tx->room->room_number ?? '-' }}</p>
                @if(!$tx->is_guest_data_complete)
                  <span class="bg-rose-100 text-rose-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full inline-flex items-center gap-1 border border-rose-200" title="Data identitas tamu belum lengkap">
                    <i class="fas fa-exclamation-circle text-rose-500"></i> Data ?
                  </span>
                @endif
              </div>
              <p class="text-xs text-slate-500 font-medium truncate max-w-[170px]">{{ $tx->guest_name }}</p>

              <!-- Checkout Timing Urgency Indicator -->
              <div class="flex flex-wrap items-center gap-1.5 mt-1">
                @if($tx->checkout_urgency === 'overdue')
                  <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-md inline-flex items-center gap-1 shadow-2xs animate-pulse">
                    <i class="fas fa-clock"></i> {{ $tx->checkout_countdown_text }}
                  </span>
                @elseif($tx->checkout_urgency === 'imminent')
                  <span class="bg-amber-400 text-[#0B192C] text-[10px] font-extrabold px-2 py-0.5 rounded-md inline-flex items-center gap-1 shadow-2xs">
                    <i class="fas fa-hourglass-half text-amber-900"></i> {{ $tx->checkout_countdown_text }}
                  </span>
                @elseif($tx->checkout_urgency === 'today')
                  <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-md inline-flex items-center gap-1">
                    <i class="fas fa-calendar-day text-blue-600"></i> CO Hari Ini
                  </span>
                @endif
              </div>
            </div>
            <div class="flex items-center gap-2">
              @if(!$tx->is_guest_data_complete)
                <a href="{{ route('transactions.guestBook', $tx->id) }}" onclick="event.stopPropagation()"
                   title="Lengkapi data tamu sekarang"
                   class="bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 text-[10px] font-extrabold px-2 py-1 rounded-lg transition-all flex items-center gap-1">
                  <i class="fas fa-edit text-amber-600"></i>
                  <span>Isi</span>
                </a>
              @endif

              @if($tx->payment_status === 'paid')
                <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full">Paid</span>
              @elseif($tx->payment_status === 'partial')
                <span class="bg-[#FEF3C7] text-[#D97706] text-xs font-bold px-3 py-1 rounded-full">Partial</span>
              @else
                <span class="bg-[#FEE2E2] text-[#DC2626] text-xs font-bold px-3 py-1 rounded-full">Unpaid</span>
              @endif
            </div>
          </div>
        @empty
          <div class="py-12 text-center text-slate-400">
            <i class="fas fa-bed text-3xl mb-2 opacity-30"></i>
            <p class="text-xs font-medium">Tidak ada tamu yang sedang menginap</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>

  <!-- BOTTOM: STATUS KAMAR REAL-TIME -->
  <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50">
    
    <!-- Legend Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-stone-100">
      <h3 class="text-base font-bold text-[#0B192C]">Status Kamar Real-time</h3>
      
      <!-- Legends -->
      <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-600">
        <div class="flex items-center gap-1.5 text-rose-500 font-bold">
          <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse-dot"></span>
          <span>LIVE</span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
          <span>Available</span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-2.5 h-2.5 rounded-full bg-[#F43F5E]"></span>
          <span>Occupied</span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-2.5 h-2.5 rounded-full bg-[#F5A623]"></span>
          <span>Dirty</span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-2.5 h-2.5 rounded-full bg-[#64748B]"></span>
          <span>Maintenance</span>
        </div>
      </div>
    </div>

    <!-- Room Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5">
      @foreach($rooms as $room)
        @php
          $status = $room->status;
          $activeTx = $room->transactions->first();
        @endphp

        @if($status === 'available')
          <!-- Available Room Card -->
          <a href="{{ route('checkin', ['room_id' => $room->id]) }}" 
             class="group rounded-2xl p-4 bg-[#E8F8F0] border border-[#A7F3D0] hover:shadow-md transition-all flex flex-col justify-between min-h-[110px]">
            <div>
              <p class="text-2xl font-extrabold text-[#10B981] group-hover:scale-105 transition-transform">{{ $room->room_number }}</p>
              <p class="text-[11px] font-medium text-emerald-800/80 truncate">{{ $room->type }}</p>
            </div>
            <div class="mt-2 text-center">
              <span class="text-[10px] font-bold text-emerald-700 bg-white/80 py-0.5 px-2.5 rounded-full inline-block shadow-xs">
                Available
              </span>
            </div>
          </a>

        @elseif($status === 'occupied')
          @php
            $isOverdue = ($activeTx && $activeTx->checkout_urgency === 'overdue');
            $isImminent = ($activeTx && $activeTx->checkout_urgency === 'imminent');
            $isIncomplete = ($activeTx && !$activeTx->is_guest_data_complete);

            $cardBorder = 'border-[#FECDD3]';
            $cardBg = 'bg-[#FDF2F2]';
            if ($isOverdue) {
              $cardBorder = 'border-rose-500 ring-2 ring-rose-300';
              $cardBg = 'bg-rose-50/80';
            } elseif ($isImminent) {
              $cardBorder = 'border-amber-400 ring-2 ring-amber-300';
              $cardBg = 'bg-amber-50/60';
            } elseif ($isIncomplete) {
              $cardBorder = 'border-amber-400';
              $cardBg = 'bg-amber-50/50';
            }
          @endphp
          <!-- Occupied Room Card -->
          <div onclick="openCheckoutModal({{ $activeTx ? $activeTx->id : 0 }})" 
               class="group rounded-2xl p-4 {{ $cardBg }} border {{ $cardBorder }} hover:shadow-md transition-all flex flex-col justify-between min-h-[110px] cursor-pointer relative">
            <div>
              <div class="flex items-center justify-between">
                <p class="text-2xl font-extrabold text-[#F43F5E] group-hover:scale-105 transition-transform">{{ $room->room_number }}</p>
                <div class="flex items-center gap-1">
                  @if($isOverdue)
                    <span class="text-[9px] font-black text-white bg-rose-600 px-1.5 py-0.5 rounded-md flex items-center gap-0.5 animate-pulse" title="Melewati batas waktu checkout">
                      <i class="fas fa-clock"></i> Overdue
                    </span>
                  @elseif($isImminent)
                    <span class="text-[9px] font-black text-[#0B192C] bg-amber-400 px-1.5 py-0.5 rounded-md flex items-center gap-0.5" title="Mendekati checkout">
                      <i class="fas fa-hourglass-half"></i> <2j
                    </span>
                  @endif
                  @if($isIncomplete)
                    <span class="text-[9px] font-black text-amber-800 bg-amber-300/90 px-1.5 py-0.5 rounded-md flex items-center gap-0.5 shadow-2xs" title="Data tamu belum lengkap">
                      <i class="fas fa-exclamation-triangle text-amber-700"></i>
                    </span>
                  @endif
                </div>
              </div>
              <p class="text-[11px] font-medium text-rose-800/80 truncate">{{ $room->type }}</p>
            </div>
            <div class="mt-2 text-center">
              @if($isOverdue)
                <span class="text-[9px] font-extrabold text-white bg-rose-600 py-0.5 px-2 rounded-full inline-block shadow-xs animate-pulse">
                  🚨 {{ $activeTx->checkout_countdown_text }}
                </span>
              @elseif($isImminent)
                <span class="text-[9px] font-extrabold text-amber-950 bg-amber-300 py-0.5 px-2 rounded-full inline-block shadow-xs">
                  ⏳ {{ $activeTx->checkout_countdown_text }}
                </span>
              @elseif($isIncomplete)
                <span class="text-[9px] font-extrabold text-amber-900 bg-amber-200/90 py-0.5 px-2 rounded-full inline-block shadow-xs">
                  ⚠️ Data Belum Lengkap
                </span>
              @else
                <span class="text-[10px] font-bold text-rose-700 bg-white/80 py-0.5 px-2.5 rounded-full inline-block shadow-xs">
                  Occupied
                </span>
              @endif
            </div>
          </div>

        @elseif($status === 'dirty')
          <!-- Dirty Room Card (1-Click Mark Clean) -->
          <form method="POST" action="{{ route('rooms.markClean', $room->id) }}" class="m-0">
            @csrf
            <button type="submit" 
                    title="Klik untuk tandai kamar selesai dibersihkan"
                    class="w-full text-left group rounded-2xl p-4 bg-[#FEF9EE] border border-[#FDE68A] hover:shadow-md transition-all flex flex-col justify-between min-h-[110px]">
              <div>
                <p class="text-2xl font-extrabold text-[#F5A623] group-hover:scale-105 transition-transform">{{ $room->room_number }}</p>
                <p class="text-[11px] font-medium text-amber-800/80 truncate">{{ $room->type }}</p>
              </div>
              <div class="mt-2 text-center">
                <span class="text-[10px] font-bold text-amber-800 bg-white/80 py-0.5 px-2.5 rounded-full inline-block shadow-xs">
                  Dirty (Bersihkan)
                </span>
              </div>
            </button>
          </form>

        @else
          <!-- Maintenance Room Card -->
          <div class="rounded-2xl p-4 bg-[#F1F5F9] border border-[#E2E8F0] flex flex-col justify-between min-h-[110px] opacity-80">
            <div>
              <p class="text-2xl font-extrabold text-slate-500">{{ $room->room_number }}</p>
              <p class="text-[11px] font-medium text-slate-500 truncate">{{ $room->type }}</p>
            </div>
            <div class="mt-2 text-center">
              <span class="text-[10px] font-bold text-slate-600 bg-white/80 py-0.5 px-2.5 rounded-full inline-block shadow-xs">
                Maintenance
              </span>
            </div>
          </div>
        @endif

      @endforeach
    </div>

  </div>

</div>

<!-- CHECKOUT QUICK MODAL -->
<div id="quickCheckoutModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl relative border border-stone-200">
    <button onclick="closeCheckoutModal()" class="absolute right-5 top-5 text-slate-400 hover:text-slate-600 p-2">
      <i class="fas fa-times text-lg"></i>
    </button>

    <h3 class="text-lg font-bold text-[#0B192C] mb-1" id="modalRoomTitle">Checkout Cepat</h3>
    <p class="text-xs text-slate-400 mb-4" id="modalGuestInfo">Memuat data transaksi...</p>

    <!-- Incomplete guest warning inside checkout modal -->
    <div id="modalIncompleteWarning" class="hidden mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-300 text-rose-900 text-xs flex items-center justify-between gap-3 shadow-xs">
      <div class="flex items-center gap-2.5">
        <i class="fas fa-exclamation-triangle text-rose-500 text-sm shrink-0"></i>
        <div>
          <span class="font-bold block">Data Identitas Tamu Belum Lengkap!</span>
          <span class="text-rose-700 text-[11px]">Tamu masuk via Express Check-in dan belum ada NIK.</span>
        </div>
      </div>
      <a id="modalGuestBookLink" href="#" 
         class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-[11px] px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-all shrink-0">
        Isi Sekarang
      </a>
    </div>

    <!-- Approaching / Overdue checkout alert inside modal -->
    <div id="modalCheckoutUrgencyWarning" class="hidden mb-4 p-3.5 rounded-2xl text-xs flex items-center justify-between gap-3 shadow-xs">
      <div class="flex items-center gap-2.5">
        <i id="modalCheckoutUrgencyIcon" class="text-sm shrink-0"></i>
        <div>
          <span class="font-bold block" id="modalCheckoutUrgencyTitle">Peringatan Checkout</span>
          <span class="text-[11px] block" id="modalCheckoutUrgencySub">...</span>
        </div>
      </div>
      <a id="modalExtendLink" href="#" class="bg-[#0B192C] hover:bg-[#152e4d] text-white font-extrabold text-[11px] px-3 py-1.5 rounded-xl whitespace-nowrap transition-all shrink-0">
        Extend Stay
      </a>
    </div>

    <form id="modalCheckoutForm" method="POST" action="">
      @csrf
      
      <div class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Tambahan</label>
          <input type="text" name="additional_charges_note" placeholder="Overtime / Minibar / Laundry"
                 class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Nominal Tambahan (Rp)</label>
          <input type="number" name="additional_charges" id="modalAdditionalCharges" value="0" min="0"
                 oninput="recalcModalTotal()"
                 class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <!-- Summary box -->
        <div class="bg-[#F8F5EF] p-4 rounded-2xl space-y-1.5 text-xs">
          <div class="flex justify-between text-slate-600">
            <span>Tagihan Kamar:</span>
            <strong class="text-slate-800" id="modalBasePrice">Rp 0</strong>
          </div>
          <div class="flex justify-between text-slate-600">
            <span>Biaya Tambahan:</span>
            <strong class="text-slate-800" id="modalAdditionalDisplay">Rp 0</strong>
          </div>
          <div class="flex justify-between items-center text-slate-600">
            <span>Metode Bayar Awal:</span>
            <strong class="text-slate-800" id="modalPaymentMethodText">Cash</strong>
          </div>
          <div class="flex justify-between text-slate-800 font-extrabold text-sm pt-2 border-t border-stone-200">
            <span>Total Akhir:</span>
            <span class="text-[#1D58B8]" id="modalFinalTotal">Rp 0</span>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Dibayar (Rp)</label>
            <input type="number" name="paid_amount" id="modalPaidAmount" required min="0"
                   class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Metode Bayar Checkout</label>
            <select name="payment_method_id" id="modalPaymentMethodSelect"
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 text-xs md:text-sm bg-white font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400">
              @foreach(\App\Models\PaymentMethod::active()->get() as $pm)
                <option value="{{ $pm->id }}" class="text-slate-800 font-semibold py-1">
                  {{ $pm->bank_name ?: $pm->name }}@if(!empty($pm->account_number)) - {{ $pm->account_number }}@endif
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Hidden required checkout inputs -->
        <input type="hidden" name="cashier_name" value="{{ auth()->user()->name }}">
        <input type="hidden" name="shift" value="{{ (now()->hour >= 7 && now()->hour < 19) ? 'Pagi' : 'Malam' }}">

        <!-- Guarantee return checkbox -->
        <div class="pt-1">
          <label class="flex items-center gap-2.5 text-xs text-slate-700 font-semibold cursor-pointer">
            <input type="checkbox" name="guarantee_returned" value="1" required class="rounded text-[#F5A623] focus:ring-amber-400">
            <span>Jaminan identitas (KTP/SIM) sudah dikembalikan — wajib</span>
          </label>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center gap-3 pt-3">
          <button type="submit" 
                  class="flex-1 bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold py-3 rounded-full text-sm shadow-md transition-all text-center">
            Checkout & Buka Struk
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  let currentTxBase = 0;

  function openCheckoutModal(txId) {
    if (!txId) {
      window.location.href = "{{ route('checkin') }}";
      return;
    }
    fetch(`/transactions/${txId}/checkout-data`)
      .then(res => res.json())
      .then(data => {
        if (!data.success) {
          alert('Transaksi tidak dapat diakses atau sudah selesai.');
          return;
        }
        const tx = data.transaction;
        document.getElementById('modalRoomTitle').innerText = `Checkout Cepat · Kamar ${tx.room.room_number}`;
        document.getElementById('modalGuestInfo').innerText = `Tamu: ${tx.guest_name} | Durasi: ${tx.duration} malam`;
        
        // Show/hide incomplete guest warning
        const warnEl = document.getElementById('modalIncompleteWarning');
        const linkEl = document.getElementById('modalGuestBookLink');
        if (warnEl && linkEl) {
          if (!tx.is_guest_data_complete) {
            warnEl.classList.remove('hidden');
            linkEl.href = `/transactions/${tx.id}/guest-book`;
          } else {
            warnEl.classList.add('hidden');
          }
        }

        // Show/hide checkout urgency warning
        const urgencyEl = document.getElementById('modalCheckoutUrgencyWarning');
        const urgencyTitle = document.getElementById('modalCheckoutUrgencyTitle');
        const urgencySub = document.getElementById('modalCheckoutUrgencySub');
        const urgencyIcon = document.getElementById('modalCheckoutUrgencyIcon');
        const extendLink = document.getElementById('modalExtendLink');

        if (urgencyEl && urgencyTitle && urgencySub && urgencyIcon && extendLink) {
          if (tx.checkout_urgency === 'overdue') {
            urgencyEl.className = 'mb-4 p-3.5 rounded-2xl bg-rose-50 border border-rose-400 text-rose-950 text-xs flex items-center justify-between gap-3 shadow-xs';
            urgencyTitle.innerText = `🚨 Lewat Batas Checkout (${tx.checkout_countdown_text})!`;
            urgencySub.innerText = `Batas checkout jam 12:00 WIB. Harap segera proses checkout atau perpanjang masa inap.`;
            urgencyIcon.className = 'fas fa-clock text-rose-600 text-sm shrink-0 animate-pulse';
            urgencyEl.classList.remove('hidden');
            extendLink.href = `/front-office?tx_id=${tx.id}`;
          } else if (tx.checkout_urgency === 'imminent') {
            urgencyEl.className = 'mb-4 p-3.5 rounded-2xl bg-amber-50 border border-amber-400 text-amber-950 text-xs flex items-center justify-between gap-3 shadow-xs';
            urgencyTitle.innerText = `⏳ Mendekati Waktu Checkout (${tx.checkout_countdown_text})!`;
            urgencySub.innerText = `Batas waktu checkout kamar ini adalah pukul 12:00 WIB hari ini.`;
            urgencyIcon.className = 'fas fa-hourglass-half text-amber-600 text-sm shrink-0';
            urgencyEl.classList.remove('hidden');
            extendLink.href = `/front-office?tx_id=${tx.id}`;
          } else if (tx.checkout_urgency === 'today') {
            urgencyEl.className = 'mb-4 p-3.5 rounded-2xl bg-blue-50 border border-blue-200 text-blue-950 text-xs flex items-center justify-between gap-3 shadow-xs';
            urgencyTitle.innerText = `ℹ️ Jadwal Checkout Hari Ini`;
            urgencySub.innerText = `Pukul 12:00 WIB (${tx.checkout_countdown_text}).`;
            urgencyIcon.className = 'fas fa-info-circle text-blue-600 text-sm shrink-0';
            urgencyEl.classList.remove('hidden');
            extendLink.href = `/front-office?tx_id=${tx.id}`;
          } else {
            urgencyEl.classList.add('hidden');
          }
        }
        
        // Set payment method display & select
        const pmText = document.getElementById('modalPaymentMethodText');
        const pmSelect = document.getElementById('modalPaymentMethodSelect');
        if (pmText) {
          pmText.innerText = (tx.payment_method && (tx.payment_method.bank_name || tx.payment_method.name)) 
            ? (tx.payment_method.bank_name || tx.payment_method.name) 
            : 'Cash';
        }
        if (pmSelect && tx.payment_method_id) {
          pmSelect.value = tx.payment_method_id;
        }

        currentTxBase = tx.room.price_per_night * tx.duration;
        document.getElementById('modalBasePrice').innerText = 'Rp ' + currentTxBase.toLocaleString('id-ID');
        document.getElementById('modalPaidAmount').value = currentTxBase;
        document.getElementById('modalAdditionalCharges').value = 0;
        
        recalcModalTotal();

        document.getElementById('modalCheckoutForm').action = `/transactions/checkout/${tx.id}`;
        document.getElementById('quickCheckoutModal').classList.remove('hidden');
      })
      .catch(err => {
        window.location.href = `/front-office?tx_id=${txId}`;
      });
  }

  function closeCheckoutModal() {
    document.getElementById('quickCheckoutModal').classList.add('hidden');
  }

  function closeOverdueModal() {
    const modal = document.getElementById('overdueCheckoutModal');
    if (modal) modal.classList.add('hidden');
  }

  function recalcModalTotal() {
    const addVal = parseInt(document.getElementById('modalAdditionalCharges').value) || 0;
    const finalTotal = currentTxBase + addVal;
    document.getElementById('modalAdditionalDisplay').innerText = 'Rp ' + addVal.toLocaleString('id-ID');
    document.getElementById('modalFinalTotal').innerText = 'Rp ' + finalTotal.toLocaleString('id-ID');
    document.getElementById('modalPaidAmount').value = finalTotal;
  }
</script>
@endpush

@endsection
