@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-slate-500 mt-2 text-base">Dashboard Hotel Nuansa</p>
  </div>

  <!-- Summary Stats -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Stat Card 1: Teal -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Total Kamar</p>
          <p class="text-4xl font-bold text-slate-800">{{ $totalRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Kapasitas Hotel</p>
        </div>
        <div class="w-14 h-14 bg-teal-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-door-open text-2xl text-teal-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 2: Emerald -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Kamar Tersedia</p>
          <p class="text-4xl font-bold text-slate-800">{{ $availableRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Siap Ditempati</p>
        </div>
        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 3: Rose -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Kamar Terisi</p>
          <p class="text-4xl font-bold text-slate-800">{{ $occupiedRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Sedang Dihuni</p>
        </div>
        <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-user text-2xl text-rose-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 4: Amber (Dirty) -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Perlu Cleaning</p>
          <p class="text-4xl font-bold text-slate-800">{{ $dirtyRooms }}</p>
        </div>
        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-broom text-2xl text-amber-600"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 5: Blue -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Omset Hari Ini</p>
          <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
          <p class="text-sm text-slate-400 mt-2">Total Pendapatan</p>
        </div>
        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-money-bill-wave text-2xl text-blue-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Bar Chart Section -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <!-- Revenue Chart -->
    <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
      <div class="mb-2">
        <h2 class="text-sm font-bold text-slate-800">Grafik Pendapatan</h2>
        <p class="text-slate-500 text-xs mt-0.5">Revenue 7 hari terakhir</p>
      </div>
      <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>

    <!-- Transactions Chart -->
    <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
      <div class="mb-2">
        <h2 class="text-sm font-bold text-slate-800">Grafik Transaksi</h2>
        <p class="text-slate-500 text-xs mt-0.5">Jumlah transaksi selesai 7 hari terakhir</p>
      </div>
      <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
        <canvas id="transactionsChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Room Grid -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
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

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      @foreach($rooms->take(8) as $room)
        @php
          $statusColor = match($room->status) {
            'available' => 'bg-gradient-to-br from-green-400 to-green-600 hover:from-green-500 hover:to-green-700',
            'occupied' => 'bg-gradient-to-br from-red-400 to-red-600 hover:from-red-500 hover:to-red-700',
            'dirty' => 'bg-gradient-to-br from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600',
            'maintenance' => 'bg-gradient-to-br from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700',
            default => 'bg-gradient-to-br from-gray-400 to-gray-600'
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
          <a href="{{ route('transactions.create', $room->id) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</div>
          </a>
        @else
          <a href="{{ route('rooms.edit', $room) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1 cursor-pointer">
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
  <div class="card p-8 rounded-2xl bg-white shadow-lg">
    <div class="mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Transaksi Aktif</h2>
      <p class="text-gray-600 text-sm mt-2">Daftar pelanggan yang sedang menginap</p>
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
            <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
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
              <tr class="hover:bg-blue-50 transition-colors duration-150 border-b border-gray-100 last:border-0">
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
  // Revenue Chart
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($chartLabels) !!},
      datasets: [{
        label: 'Pendapatan (Rp)',
        data: {!! json_encode($chartData) !!},
        backgroundColor: 'rgba(59, 130, 246, 0.8)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 2,
        borderRadius: {
          topLeft: 8,
          topRight: 8,
          bottomLeft: 0,
          bottomRight: 0
        },
        borderSkipped: false,
        maxBarThickness: 50,
        categoryPercentage: 0.8,
        barPercentage: 0.9
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
            weight: 'bold'
          },
          bodyFont: {
            size: 13
          },
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
            font: {
              size: 11
            },
            padding: 10
          },
          grid: {
            color: 'rgba(200, 200, 200, 0.2)',
            borderDash: [5, 5],
            drawBorder: false
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              size: 11,
              weight: '600'
            }
          }
        }
      }
    }
  });

  // Transactions Chart
  const transactionsCtx = document.getElementById('transactionsChart').getContext('2d');
  const transactionsChart = new Chart(transactionsCtx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($chartLabels) !!},
      datasets: [{
        label: 'Jumlah Transaksi',
        data: {!! json_encode($chartTransactions) !!},
        backgroundColor: 'rgba(16, 185, 129, 0.8)',
        borderColor: 'rgba(16, 185, 129, 1)',
        borderWidth: 2,
        borderRadius: {
          topLeft: 8,
          topRight: 8,
          bottomLeft: 0,
          bottomRight: 0
        },
        borderSkipped: false,
        maxBarThickness: 50,
        categoryPercentage: 0.8,
        barPercentage: 0.9
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          enabled: true,
          mode: 'index',
          intersect: false,
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 13
          },
          bodyFont: {
            size: 14,
            weight: 'bold'
          },
          callbacks: {
            label: function(context) {
              return context.parsed.y + ' transaksi';
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            font: {
              size: 11
            },
            padding: 10
          },
          grid: {
            color: 'rgba(200, 200, 200, 0.2)',
            borderDash: [5, 5],
            drawBorder: false
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            font: {
              size: 11,
              weight: '600'
            }
          }
        }
      }
    }
  });
</script>
@endsection
