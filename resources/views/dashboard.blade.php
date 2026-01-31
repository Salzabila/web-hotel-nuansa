@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 md:px-6 lg:px-8 py-6">
  <!-- Header with Quick Actions -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
      <p class="text-slate-500 mt-1 text-sm">Dashboard Hotel Nuansa</p>
    </div>
    <!-- Quick Actions -->
    <div class="flex gap-3">
      <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md" aria-label="Transaksi">
        <i class="fas fa-receipt"></i>
        <span class="hidden md:inline">Transaksi</span>
      </a>
      <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 text-white font-semibold px-4 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md" style="background-color: #f97316; hover:background-color: #ea580c;" aria-label="Pengeluaran">
        <i class="fas fa-money-bill-wave"></i>
        <span class="hidden md:inline">Pengeluaran</span>
      </a>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Total Kamar -->
      <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
        <div class="flex items-center justify-between gap-2">
          <div class="flex-1">
            <p class="text-slate-500 text-xs font-medium">Total Kamar</p>
            <p class="text-2xl font-bold text-slate-800 my-1">{{ $totalRooms }}</p>
            <p class="text-xs text-slate-400">Kapasitas Hotel</p>
          </div>
          <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-door-open text-lg text-teal-500"></i>
          </div>
        </div>
      </div>

      <!-- Kamar Tersedia -->
      <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
        <div class="flex items-center justify-between gap-2">
          <div class="flex-1">
            <p class="text-slate-500 text-xs font-medium">Kamar Tersedia</p>
            <p class="text-2xl font-bold text-slate-800 my-1">{{ $availableRooms }}</p>
            <p class="text-xs text-slate-400">Siap Ditempati</p>
          </div>
          <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check-circle text-lg text-emerald-500"></i>
          </div>
        </div>
      </div>

      <!-- Kamar Terisi -->
      <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
        <div class="flex items-center justify-between gap-2">
          <div class="flex-1">
            <p class="text-slate-500 text-xs font-medium">Kamar Terisi</p>
            <p class="text-2xl font-bold text-slate-800 my-1">{{ $occupiedRooms }}</p>
            <p class="text-xs text-slate-400">Sedang Dihuni</p>
          </div>
          <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user text-lg text-rose-500"></i>
          </div>
        </div>
      </div>

      <!-- Perlu Cleaning -->
      <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
        <div class="flex items-center justify-between gap-2">
          <div class="flex-1">
            <p class="text-slate-500 text-xs font-medium">Perlu Cleaning</p>
            <p class="text-2xl font-bold text-slate-800 my-1">{{ $dirtyRooms }}</p>
            <p class="text-xs text-slate-400">Butuh Pembersihan</p>
          </div>
          <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas fa-broom text-lg text-amber-600"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Financial Highlight -->
  <div class="mb-8">
    <div class="bg-blue-600 hover:shadow-xl transition-all duration-300 p-6 rounded-xl shadow-md border border-blue-500">
      <div class="flex items-center justify-between">
        <div class="flex-1">
          <p class="text-blue-100 text-sm font-medium mb-2">Omset Hari Ini</p>
          <p class="text-3xl md:text-4xl font-black text-white mb-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
          <p class="text-blue-100 text-sm">Total pendapatan hari ini</p>
        </div>
        <div class="w-16 h-16 md:w-20 md:h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
          <i class="fas fa-money-bill-wave text-4xl text-white"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Grid: Charts + Financial Panel -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    <!-- LEFT: Charts Area (col-md-8) -->
    <div class="lg:col-span-8">
      <div class="bg-white p-5 rounded-2xl shadow-lg border border-slate-200">
        <!-- Tabs Navigation -->
        <div class="flex gap-2 mb-4 border-b border-slate-200 pb-3">
          <button onclick="switchTab('revenue')" id="tab-revenue" class="tab-btn px-4 py-2 rounded-lg font-semibold text-sm transition-all bg-blue-500 text-white">
            <i class="fas fa-chart-line mr-2"></i>Grafik Pendapatan
          </button>
          <button onclick="switchTab('transactions')" id="tab-transactions" class="tab-btn px-4 py-2 rounded-lg font-semibold text-sm transition-all bg-slate-100 text-slate-600 hover:bg-slate-200">
            <i class="fas fa-chart-bar mr-2"></i>Grafik Transaksi
          </button>
        </div>

        <!-- Revenue Chart Tab -->
        <div id="content-revenue" class="tab-content">
          <div class="mb-3">
            <h2 class="text-lg font-bold text-slate-800">Pendapatan Harian</h2>
            <p class="text-slate-500 text-sm mt-0.5">Total pendapatan 7 hari terakhir</p>
          </div>
          <div class="relative w-full h-64 md:h-80">
            @if(empty($chartData) || array_sum($chartData) == 0)
              <!-- Empty State -->
              <div class="flex flex-col items-center justify-center h-full text-slate-400">
                <i class="fas fa-chart-line text-6xl mb-4 opacity-20"></i>
                <p class="text-lg font-semibold text-slate-500">Belum ada data pendapatan</p>
                <p class="text-sm text-slate-400 mt-1">Data akan muncul setelah ada transaksi selesai</p>
              </div>
            @else
              <canvas id="revenueChart"></canvas>
            @endif
          </div>
        </div>

        <!-- Transactions Chart Tab -->
        <div id="content-transactions" class="tab-content hidden">
          <div class="mb-3">
            <h2 class="text-lg font-bold text-slate-800">Transaksi Harian</h2>
            <p class="text-slate-500 text-sm mt-0.5">Jumlah transaksi selesai 7 hari terakhir</p>
          </div>
          <div class="relative w-full h-64 md:h-80">
            @if(empty($chartTransactions) || array_sum($chartTransactions) == 0)
              <!-- Empty State -->
              <div class="flex flex-col items-center justify-center h-full text-slate-400">
                <i class="fas fa-chart-bar text-6xl mb-4 opacity-20"></i>
                <p class="text-lg font-semibold text-slate-500">Belum ada data transaksi</p>
                <p class="text-sm text-slate-400 mt-1">Data akan muncul setelah ada transaksi selesai</p>
              </div>
            @else
              <canvas id="transactionsChart"></canvas>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Financial Recap Panel (col-md-4) -->
    <div class="lg:col-span-4">
      <div class="bg-white p-5 rounded-2xl shadow-lg border border-slate-200 h-full">
        <div class="mb-4">
          <h2 class="text-lg font-bold text-slate-800">Rekap Bulan Ini</h2>
          <p class="text-slate-500 text-sm mt-0.5">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
        </div>
        
        <div class="relative w-full h-48 mb-4">
          @if($monthlyRevenue == 0 && $monthlyExpenses == 0 && $monthlyTCCommission == 0)
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center h-full text-slate-400">
              <i class="fas fa-chart-pie text-5xl mb-3 opacity-20"></i>
              <p class="text-sm font-semibold text-slate-500">Belum ada data bulan ini</p>
            </div>
          @else
            <canvas id="monthlyPieChart"></canvas>
          @endif
        </div>
        
        <!-- Enhanced Legend with Better Spacing -->
        <div class="space-y-3 mt-5">
          <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 bg-emerald-500 rounded-full shadow-sm"></span>
              <span class="text-sm font-semibold text-slate-700">Pendapatan</span>
            </div>
            <span class="text-sm font-bold text-emerald-700">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</span>
          </div>
          
          <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 bg-orange-500 rounded-full shadow-sm"></span>
              <span class="text-sm font-semibold text-slate-700">Pengeluaran</span>
            </div>
            <span class="text-sm font-bold text-orange-700">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</span>
          </div>
          
          <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 bg-purple-500 rounded-full shadow-sm"></span>
              <span class="text-sm font-semibold text-slate-700">Komisi TC</span>
            </div>
            <span class="text-sm font-bold text-purple-700">Rp {{ number_format($monthlyTCCommission, 0, ',', '.') }}</span>
          </div>
          
          <!-- Laba Bersih -->
          <div class="flex items-center justify-between p-4 {{ $monthlyProfit >= 0 ? 'bg-blue-50 border-2 border-blue-200' : 'bg-red-50 border-2 border-red-200' }} rounded-xl mt-4">
            <div class="flex items-center gap-2.5">
              <span class="w-4 h-4 {{ $monthlyProfit >= 0 ? 'bg-blue-500' : 'bg-red-500' }} rounded-full shadow-md"></span>
              <span class="text-base font-bold {{ $monthlyProfit >= 0 ? 'text-blue-800' : 'text-red-800' }}">Laba Bersih</span>
            </div>
            <span class="text-lg font-black {{ $monthlyProfit >= 0 ? 'text-blue-800' : 'text-red-800' }}">{{ $monthlyProfit >= 0 ? '+' : '' }}Rp {{ number_format($monthlyProfit, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Master Kamar Section (with proper top margin) -->
  <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 mt-8">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Master Kamar</h2>
        <p class="text-slate-500 text-sm mt-1">Status dan ketersediaan kamar</p>
      </div>
       <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg">
        <i class="fas fa-external-link-alt"></i> Lihat Semua
      </a>
    </div>
    
    <div class="flex flex-wrap gap-6 mb-6 text-sm bg-slate-50 p-5 rounded-xl">
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-green-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Tersedia</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-red-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Terisi</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-slate-400 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Kotor/Cleaning</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-yellow-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Pemeliharaan</span>
      </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">
      @foreach($rooms->take(8) as $room)
        @php
          $statusColor = match($room->status) {
            'available' => 'bg-green-500 hover:bg-green-600',
            'occupied' => 'bg-red-500 hover:bg-red-600',
            'dirty' => 'bg-slate-400 hover:bg-slate-500',
            'maintenance' => 'bg-yellow-500 hover:bg-yellow-600',
            default => 'bg-slate-500'
          };
          $statusText = match($room->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'dirty' => 'Kotor',
            'maintenance' => 'Pemeliharaan',
            default => 'Unknown'
          };
          
        @endphp
        @if($room->status === 'available')
          <a href="{{ route('transactions.create', $room->id) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1 hover:scale-105 cursor-pointer" aria-label="Book room {{ $room->room_number }}">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</div>
          </a>
        @else
          <a href="{{ route('rooms.edit', $room) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1 hover:scale-105 cursor-pointer" aria-label="Edit room {{ $room->room_number }}">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
          </a>
        @endif
      @endforeach
    </div>
  </div>

  <!-- Active Transactions -->
  <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 mt-8">
    <div class="mb-6">
      <h2 class="text-xl md:text-2xl font-bold text-slate-800">Transaksi Aktif</h2>
      <p class="text-slate-500 text-sm mt-1">Daftar pelanggan yang sedang menginap</p>
    </div>
    
    @php
      $activeTransactions = \App\Models\Transaction::with('room', 'user')
        ->where('status', 'active')
        ->orderBy('check_in', 'desc')
        ->limit(10)
        ->get();
    @endphp

    @if($activeTransactions->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b-2 border-slate-200 bg-slate-50">
              <th class="text-left py-5 px-6 font-bold text-gray-900">Invoice</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Pelanggan</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Kamar</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Check-in</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Check-out</th>
              <th class="text-right py-5 px-6 font-bold text-gray-900">Total</th>
              <th class="text-center py-5 px-6 font-bold text-gray-900">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($activeTransactions as $tx)
              <tr class="hover:bg-slate-50 transition-colors duration-200 border-b border-slate-100 last:border-0">
                <td class="py-5 px-6 font-bold text-blue-600 text-base">{{ $tx->invoice_code }}</td>
                <td class="py-5 px-6 text-gray-900 font-semibold">{{ $tx->guest_name }}</td>
                <td class="py-5 px-6 text-gray-900 font-medium">{{ $tx->room->room_number }}</td>
                <td class="py-5 px-6 text-gray-700">{{ $tx->check_in->format('d/m/y H:i') }}</td>
                <td class="py-5 px-6 text-gray-700">
                  @if($tx->check_out)
                    {{ $tx->check_out->format('d/m/y H:i') }}
                  @else
                    <span class="text-yellow-600 font-semibold">Menginap</span>
                  @endif
                </td>
                <td class="py-5 px-6 text-right font-bold text-gray-900">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                <td class="py-5 px-6 text-center">
                  <button 
                    onclick="openCheckoutModal({{ $tx->id }})" 
                    class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-lg">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Check-out</span>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="text-center py-12 text-gray-500">
        <i class="fas fa-inbox text-4xl mb-4 opacity-30"></i>
        <p class="text-lg">Tidak ada transaksi aktif saat ini</p>
      </div>
    @endif
  </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // ===== STEP 1: Check if Chart.js Library is Loaded =====
    if (typeof Chart === 'undefined') {
      console.error("❌ Chart.js Library NOT FOUND!");
      alert("Error: Chart.js belum terinstall atau gagal dimuat.");
      return;
    }
    console.log("✅ Chart.js Library loaded successfully.");

    // ===== STEP 2: REVENUE CHART (DUMMY DATA) =====
    const revenueCanvas = document.getElementById('revenueChart');
    if (revenueCanvas) {
      console.log("✅ Revenue Canvas element found.");
      const revenueCtx = revenueCanvas.getContext('2d');
      
      const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
          // DUMMY DATA - Hardcoded untuk testing
          labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
          datasets: [{
            label: 'Pendapatan Test (Dummy Data)',
            data: [500000, 750000, 300000, 900000, 1200000, 600000, 850000], // Angka Manual
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            borderRadius: 5
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // WAJIB: Agar tinggi mengikuti container
          plugins: {
            legend: {
              display: true, // Tampilkan legend
              position: 'top',
              labels: {
                font: { size: 12, weight: 'bold' }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              padding: 12,
              titleFont: { size: 14, weight: 'bold' },
              bodyFont: { size: 13 },
              callbacks: {
                label: function(context) {
                  return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                },
                font: { size: 11 }
              },
              grid: {
                color: 'rgba(200, 200, 200, 0.2)',
                borderDash: [5, 5]
              }
            },
            x: {
              grid: { display: false },
              ticks: {
                font: { size: 11, weight: '600' }
              }
            }
          }
        }
      });
      console.log("✅ Revenue Chart rendered with DUMMY DATA.");
    } else {
      console.warn("⚠️ Revenue Canvas element NOT FOUND!");
    }

    // ===== STEP 3: TRANSACTIONS CHART (DUMMY DATA) =====
    const transactionsCanvas = document.getElementById('transactionsChart');
    if (transactionsCanvas) {
      console.log("✅ Transactions Canvas element found.");
      const transactionsCtx = transactionsCanvas.getContext('2d');
      
      const transactionsChart = new Chart(transactionsCtx, {
        type: 'bar',
        data: {
          // DUMMY DATA - Hardcoded untuk testing
          labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
          datasets: [{
            label: 'Jumlah Transaksi Test (Dummy)',
            data: [5, 7, 3, 9, 12, 6, 8], // Angka Manual
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 2,
            borderRadius: 5
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: { size: 12, weight: 'bold' }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              padding: 12,
              titleFont: { size: 13 },
              bodyFont: { size: 12 }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                font: { size: 11 }
              },
              grid: {
                color: 'rgba(0, 0, 0, 0.05)'
              }
            },
            x: {
              grid: { display: false },
              ticks: {
                font: { size: 11 }
              }
            }
          }
        }
      });
      console.log("✅ Transactions Chart rendered with DUMMY DATA.");
    } else {
      console.warn("⚠️ Transactions Canvas element NOT FOUND!");
    }

    // ===== STEP 4: MONTHLY PIE CHART (DUMMY DATA) =====
    const monthlyPieCanvas = document.getElementById('monthlyPieChart');
    if (monthlyPieCanvas) {
      console.log("✅ Monthly Pie Canvas element found.");
      const monthlyPieCtx = monthlyPieCanvas.getContext('2d');
      
      const monthlyPieChart = new Chart(monthlyPieCtx, {
        type: 'doughnut',
        data: {
          // DUMMY DATA - Hardcoded untuk testing
          labels: ['Pendapatan', 'Pengeluaran', 'Komisi TC', 'Laba Bersih'],
          datasets: [{
            label: 'Rekap Keuangan Test',
            data: [5000000, 1500000, 500000, 3000000], // Angka Manual
            backgroundColor: [
              'rgba(16, 185, 129, 0.85)',  // Green - Revenue
              'rgba(249, 115, 22, 0.85)',  // Orange - Expenses
              'rgba(168, 85, 247, 0.85)',  // Purple - TC Commission
              'rgba(59, 130, 246, 0.85)'   // Blue - Profit
            ],
            borderColor: '#fff',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '60%',
          plugins: {
            legend: {
              display: false // Legend manual di HTML lebih baik
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.9)',
              padding: 14,
              titleFont: { size: 14, weight: 'bold' },
              bodyFont: { size: 13, weight: '600' },
              callbacks: {
                label: function(context) {
                  let label = context.label || '';
                  if (label) {
                    label += ': ';
                  }
                  const value = context.parsed || 0;
                  label += 'Rp ' + value.toLocaleString('id-ID');
                  
                  // Calculate percentage
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const percentage = ((value / total) * 100).toFixed(1);
                  label += ' (' + percentage + '%)';
                  
                  return label;
                }
              }
            }
          },
          animation: {
            animateRotate: true,
            animateScale: true,
            duration: 1000
          }
        }
      });
      console.log("✅ Monthly Pie Chart rendered with DUMMY DATA.");
    } else {
      console.warn("⚠️ Monthly Pie Canvas element NOT FOUND!");
    }
  
  }); // End DOMContentLoaded

  // Tab Switching Function
  function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
      content.classList.add('hidden');
    });
    
    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.classList.remove('bg-blue-500', 'text-white');
      btn.classList.add('bg-slate-100', 'text-slate-600');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Highlight selected tab button
    const activeBtn = document.getElementById('tab-' + tabName);
    activeBtn.classList.remove('bg-slate-100', 'text-slate-600');
    activeBtn.classList.add('bg-blue-500', 'text-white');
  }

  // Checkout Modal Functions
  function openCheckoutModal(transactionId) {
    const modal = document.getElementById('checkoutModal');
    
    // Fetch transaction data
    fetch(`/transactions/${transactionId}/checkout-data`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Populate modal with transaction data
        populateCheckoutModal(data.transaction);
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      } else {
        alert('Gagal memuat data transaksi');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat memuat data');
    });
  }

  function closeCheckoutModal() {
    const modal = document.getElementById('checkoutModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  function populateCheckoutModal(tx) {
    // Update invoice code
    document.getElementById('modalInvoiceCode').textContent = tx.invoice_code;
    document.getElementById('modalGuestName').textContent = tx.guest_name;
    document.getElementById('modalGuestNik').textContent = tx.guest_nik || '-';
    document.getElementById('modalGuestPhone').textContent = tx.guest_phone || '-';
    document.getElementById('modalRoomNumber').textContent = tx.room.room_number + ' - ' + tx.room.type;
    
    if (tx.guest_address) {
      document.getElementById('modalGuestAddress').textContent = tx.guest_address;
      document.getElementById('modalAddressSection').classList.remove('hidden');
    } else {
      document.getElementById('modalAddressSection').classList.add('hidden');
    }
    
    // Check-in/out dates
    document.getElementById('modalCheckIn').textContent = new Date(tx.check_in).toLocaleString('id-ID');
    document.getElementById('modalCheckOut').textContent = new Date(tx.check_out).toLocaleString('id-ID');
    document.getElementById('modalDuration').textContent = tx.duration + ' Malam';
    
    // Pricing
    const pricePerNight = tx.total_price / tx.duration;
    document.getElementById('modalPricePerNight').textContent = 'Rp ' + pricePerNight.toLocaleString('id-ID');
    document.getElementById('modalSubtotal').textContent = 'Rp ' + tx.total_price.toLocaleString('id-ID');
    document.getElementById('modalGrandTotal').textContent = 'Rp ' + tx.total_price.toLocaleString('id-ID');
    
    // Guarantee warning
    if (tx.is_ktp_held) {
      document.getElementById('modalGuaranteeWarning').classList.remove('hidden');
      document.getElementById('modalGuaranteeType').textContent = tx.guarantee_type || 'KTP';
      document.getElementById('modalGuaranteeName').textContent = tx.guest_name;
      document.getElementById('guaranteeReturnedCheckbox').required = true;
    } else {
      document.getElementById('modalGuaranteeWarning').classList.add('hidden');
      document.getElementById('guaranteeReturnedCheckbox').required = false;
    }
    
    // Set form action
    document.getElementById('checkoutForm').action = `/transactions/checkout/${tx.id}`;
    
    // Set cashiers
    populateCashiers();
  }

  function populateCashiers() {
    // Fetch cashiers if not already loaded
    const cashierSelect = document.getElementById('modalCashierName');
    if (cashierSelect.options.length <= 1) {
      fetch('/api/cashiers', {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        data.forEach(cashier => {
          const option = document.createElement('option');
          option.value = cashier.name;
          option.textContent = cashier.name;
          cashierSelect.appendChild(option);
        });
      });
    }
  }

  // Calculate total and change
  function calculateTotal() {
    const subtotal = parseFloat(document.getElementById('modalSubtotal').textContent.replace(/[^\d]/g, ''));
    const additionalCharges = parseFloat(document.getElementById('additionalCharges').value) || 0;
    const grandTotal = subtotal + additionalCharges;
    document.getElementById('modalGrandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    calculateChange();
  }

  function calculateChange() {
    const grandTotal = parseFloat(document.getElementById('modalGrandTotal').textContent.replace(/[^\d]/g, ''));
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    const change = Math.max(0, paidAmount - grandTotal);
    document.getElementById('modalChangeAmount').textContent = 'Rp ' + change.toLocaleString('id-ID');
  }

  function formatCurrency(input, hiddenFieldId) {
    let value = input.value.replace(/[^\d]/g, '');
    input.value = value ? parseInt(value).toLocaleString('id-ID') : '';
    document.getElementById(hiddenFieldId).value = value;
    
    if (hiddenFieldId === 'additionalCharges') {
      calculateTotal();
    } else if (hiddenFieldId === 'paidAmount') {
      calculateChange();
    }
  }

  // Close modal on outside click
  document.addEventListener('click', function(e) {
    const modal = document.getElementById('checkoutModal');
    if (e.target === modal) {
      closeCheckoutModal();
    }
  });
</script>

<!-- Checkout Modal -->
<div id="checkoutModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
    <form id="checkoutForm" method="POST" action="">
      @csrf
      
      <!-- Modal Header -->
      <div class="sticky top-0 bg-white border-b border-slate-200 p-6 flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Konfirmasi Check-out</h2>
          <p class="text-sm text-slate-500">Invoice: <span id="modalInvoiceCode" class="font-bold text-blue-600"></span></p>
        </div>
        <button type="button" onclick="closeCheckoutModal()" class="text-slate-400 hover:text-slate-600 text-2xl">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6 space-y-6">
        <!-- Guest Info -->
        <div class="bg-slate-50 p-4 rounded-xl">
          <h3 class="font-bold text-slate-800 mb-3">Informasi Pelanggan</h3>
          <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
              <p class="text-slate-500">Nama</p>
              <p id="modalGuestName" class="font-bold text-slate-800"></p>
            </div>
            <div>
              <p class="text-slate-500">NIK</p>
              <p id="modalGuestNik" class="font-semibold text-slate-700"></p>
            </div>
            <div>
              <p class="text-slate-500">Telepon</p>
              <p id="modalGuestPhone" class="font-semibold text-slate-700"></p>
            </div>
            <div>
              <p class="text-slate-500">Kamar</p>
              <p id="modalRoomNumber" class="font-bold text-slate-800"></p>
            </div>
          </div>
          <div id="modalAddressSection" class="hidden mt-3 pt-3 border-t border-slate-200">
            <p class="text-slate-500 text-sm">Alamat</p>
            <p id="modalGuestAddress" class="text-sm text-slate-700"></p>
          </div>
        </div>

        <!-- Guarantee Warning -->
        <div id="modalGuaranteeWarning" class="hidden bg-amber-50 border-2 border-amber-300 rounded-xl p-4">
          <div class="flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-amber-600 text-xl mt-1"></i>
            <div class="flex-1">
              <p class="font-bold text-amber-900 mb-2">⚠️ JAMINAN IDENTITAS</p>
              <p class="text-sm text-amber-800 mb-3">Kembalikan <strong><span id="modalGuaranteeType"></span> atas nama <span id="modalGuaranteeName"></span></strong> kepada pelanggan.</p>
              <div class="bg-white border border-amber-400 rounded-lg p-3">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="checkbox" id="guaranteeReturnedCheckbox" name="guarantee_returned" value="1" class="w-5 h-5 text-amber-600 rounded">
                  <span class="text-sm font-bold text-amber-900">✓ Sudah mengembalikan jaminan</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Bill Summary -->
        <div class="bg-blue-50 p-4 rounded-xl">
          <h3 class="font-bold text-slate-800 mb-3">Rincian Tagihan</h3>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-600">Check-in</span>
              <span id="modalCheckIn" class="font-semibold"></span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600">Check-out</span>
              <span id="modalCheckOut" class="font-semibold"></span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600">Durasi</span>
              <span id="modalDuration" class="font-bold"></span>
            </div>
            <div class="border-t border-slate-200 pt-2 mt-2"></div>
            <div class="flex justify-between">
              <span class="text-slate-600">Harga/Malam</span>
              <span id="modalPricePerNight" class="font-semibold"></span>
            </div>
            <div class="flex justify-between text-base font-bold">
              <span>Subtotal</span>
              <span id="modalSubtotal"></span>
            </div>
          </div>
        </div>

        <!-- Additional Charges -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Biaya Tambahan (Opsional)
          </label>
          <input type="hidden" id="additionalCharges" name="additional_charges" value="0">
          <input 
            type="text" 
            id="additionalChargesDisplay"
            placeholder="0"
            oninput="formatCurrency(this, 'additionalCharges')"
            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
        </div>

        <!-- Paid Amount -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Jumlah Dibayar <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs">WAJIB</span>
          </label>
          <input type="hidden" id="paidAmount" name="paid_amount" required>
          <input 
            type="text" 
            id="paidAmountDisplay"
            placeholder="Masukkan jumlah pembayaran"
            oninput="formatCurrency(this, 'paidAmount')"
            required
            class="w-full px-4 py-3 border-2 border-yellow-300 bg-yellow-50 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
        </div>

        <!-- Cashier -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Nama Kasir <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs">WAJIB</span>
          </label>
          <select id="modalCashierName" name="cashier_name" required class="w-full px-4 py-3 border-2 border-yellow-300 bg-yellow-50 rounded-xl">
            <option value="">-- Pilih Kasir --</option>
          </select>
        </div>

        <!-- Shift -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Shift <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs">WAJIB</span>
          </label>
          <select name="shift" required class="w-full px-4 py-3 border-2 border-yellow-300 bg-yellow-50 rounded-xl">
            @php
              $hour = now()->hour;
              $currentShift = ($hour >= 7 && $hour < 19) ? 'Pagi' : 'Malam';
            @endphp
            <option value="Pagi" {{ $currentShift === 'Pagi' ? 'selected' : '' }}>☀️ Pagi (07:00 - 19:00)</option>
            <option value="Malam" {{ $currentShift === 'Malam' ? 'selected' : '' }}>🌙 Malam (19:00 - 07:00)</option>
          </select>
        </div>

        <!-- Total & Change -->
        <div class="bg-emerald-50 p-4 rounded-xl space-y-2">
          <div class="flex justify-between text-lg font-bold">
            <span>TOTAL</span>
            <span id="modalGrandTotal" class="text-emerald-700"></span>
          </div>
          <div class="flex justify-between text-base">
            <span class="text-slate-600">Kembalian</span>
            <span id="modalChangeAmount" class="font-bold text-emerald-700">Rp 0</span>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="sticky bottom-0 bg-slate-50 border-t border-slate-200 p-6 flex gap-3">
        <button type="button" onclick="closeCheckoutModal()" class="flex-1 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition">
          Batal
        </button>
        <button type="submit" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition">
          <i class="fas fa-check mr-2"></i>
          Konfirmasi Check-out
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
