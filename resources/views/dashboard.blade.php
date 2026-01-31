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
                  <a href="{{ route('transactions.checkout', $tx->id) }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-lg">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Check-out</span>
                  </a>
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
</script>
@endsection
