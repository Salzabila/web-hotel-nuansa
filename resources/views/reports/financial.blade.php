@extends('layouts.app')

@php
  use Carbon\Carbon;
@endphp

@section('content')
<div>
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Laporan Keuangan</h1>
    <p class="text-gray-600 mt-1">Ringkasan pendapatan dan pengeluaran</p>
  </div>

  <!-- Filter Section -->
  <div class="card p-8 mb-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Filter Laporan</h3>
    <form method="GET" action="{{ route('reports.finance') }}" class="space-y-4">
      <div class="flex flex-wrap gap-4 items-end">
        <div>
          <label class="block text-sm font-semibold text-gray-900 mb-2">Dari Tanggal</label>
          <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="px-4 py-2 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-900 mb-2">Sampai Tanggal</label>
          <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="px-4 py-2 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
        </div>
        <button type="submit" class="btn btn-primary px-6 py-2 shadow-md">
          <i class="fas fa-search mr-2"></i>Filter
        </button>
        <a href="{{ route('reports.finance') }}" class="btn btn-secondary px-6 py-2 shadow-md">
          <i class="fas fa-redo mr-2"></i>Refresh
        </a>
      </div>
    </form>
  </div>

  <!-- Summary Cards - Layout Horizontal -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Kiri: Total Pelanggan -->
    <div class="stat-card rounded-2xl p-6 bg-gradient-to-br from-purple-50 to-purple-100 border-l-4 border-purple-500 hover:shadow-xl transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-purple-700 text-xs font-semibold uppercase tracking-wide">Total Pelanggan</p>
          <p class="text-5xl font-extrabold text-purple-900 mt-3">{{ $totalCustomers }}</p>
          <p class="text-xs text-purple-600 mt-2">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</p>
        </div>
        <div class="text-6xl text-purple-300 opacity-60">
          <i class="fas fa-users"></i>
        </div>
      </div>
    </div>

    <!-- Kanan: Total Pendapatan/Omset -->
    <div class="stat-card rounded-2xl p-6 bg-gradient-to-br from-green-50 to-green-100 border-l-4 border-green-500 hover:shadow-xl transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-green-700 text-xs font-semibold uppercase tracking-wide">Total Pendapatan</p>
          <p class="text-4xl font-extrabold text-green-900 mt-3">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
          <p class="text-xs text-green-600 mt-2">Omset Kotor</p>
        </div>
        <div class="text-6xl text-green-300 opacity-60">
          <i class="fas fa-money-bill-wave"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Biaya, Gaji, Laba Bersih -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Biaya Operasional -->
    <div class="stat-card rounded-2xl p-6 bg-gradient-to-br from-amber-50 to-amber-100 border-l-4 border-amber-500 hover:shadow-xl transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-amber-700 text-xs font-semibold uppercase tracking-wide">Biaya Operasional</p>
          <p class="text-3xl font-extrabold text-amber-900 mt-3">Rp {{ number_format($operationalCost, 0, ',', '.') }}</p>
          <p class="text-xs text-amber-600 mt-2">Listrik, Air, dll</p>
        </div>
        <div class="text-5xl text-amber-300 opacity-60">
          <i class="fas fa-bolt"></i>
        </div>
      </div>
    </div>

    <!-- Total Gaji -->
    <div class="stat-card rounded-2xl p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-500 hover:shadow-xl transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-blue-700 text-xs font-semibold uppercase tracking-wide">Total Gaji</p>
          <p class="text-3xl font-extrabold text-blue-900 mt-3">Rp {{ number_format($employeeSalary, 0, ',', '.') }}</p>
          <p class="text-xs text-blue-600 mt-2">Gaji Karyawan</p>
        </div>
        <div class="text-5xl text-blue-300 opacity-60">
          <i class="fas fa-users"></i>
        </div>
      </div>
    </div>

    <!-- Laba Bersih -->
    <div class="stat-card rounded-2xl p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border-l-4 border-emerald-500 hover:shadow-xl transition-all">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-emerald-700 text-xs font-semibold uppercase tracking-wide">Laba Bersih</p>
          <p class="text-3xl font-extrabold {{ $netProfit >= 0 ? 'text-emerald-900' : 'text-red-900' }} mt-3">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
          <p class="text-xs {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-2">{{ $netProfit >= 0 ? '✓ Positif' : '✗ Negatif' }}</p>
        </div>
        <div class="text-5xl {{ $netProfit >= 0 ? 'text-emerald-300' : 'text-red-300' }} opacity-60">
          <i class="fas fa-chart-line"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Transactions & Expenses Tabs -->
  <div class="card overflow-hidden shadow-md">
    <div class="border-b-2 border-slate-200 bg-slate-50 flex">
      <button class="tab-btn flex-1 py-3 px-6 text-center font-semibold text-blue-600 border-b-2 border-blue-600" data-tab="transactions">
        <i class="fas fa-money-bill-wave mr-2"></i>Transaksi Masuk
      </button>
      <button class="tab-btn flex-1 py-3 px-6 text-center font-semibold text-gray-600 border-b-2 border-transparent" data-tab="expenses">
        <i class="fas fa-receipt mr-2"></i>Biaya Operasional
      </button>
    </div>

    <!-- Transactions Tab -->
    <div id="transactions" class="tab-content">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 bg-gray-50">
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Invoice</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Pelanggan</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Kamar</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Durasi</th>
              <th class="text-right py-3 px-6 font-semibold text-gray-900 text-sm">Harga/Malam</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Check-out</th>
              <th class="text-right py-3 px-6 font-semibold text-gray-900 text-sm">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($transactions as $tx)
              @php
                $duration = $tx->check_out ? max(1, (int) ceil($tx->check_in->diffInHours($tx->check_out) / 24)) : 1;
                $pricePerNight = $tx->room->price;
              @endphp
              <tr class="hover:bg-gray-50">
                <td class="py-3 px-6 font-medium text-blue-600 text-sm">{{ $tx->invoice_code }}</td>
                <td class="py-3 px-6 text-gray-900 text-sm">{{ $tx->guest_name }}</td>
                <td class="py-3 px-6 text-gray-900 text-sm">{{ $tx->room->room_number }}</td>
                <td class="py-3 px-6 text-gray-600 text-sm">
                  @if($tx->check_out)
                    {{ $duration }} malam
                  @else
                    -
                  @endif
                </td>
                <td class="py-3 px-6 text-right text-gray-700 text-sm">Rp {{ number_format($pricePerNight, 0, ',', '.') }}</td>
                <td class="py-3 px-6 text-gray-600 text-sm">
                  @if($tx->check_out)
                    {{ $tx->check_out->format('d M Y') }}
                  @else
                    -
                  @endif
                </td>
                <td class="py-3 px-6 text-right font-semibold text-gray-900 text-sm">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-8 text-center text-gray-500">Tidak ada transaksi</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-between items-center text-sm">
        <span class="text-gray-600">Total: <strong class="text-gray-900">Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</strong></span>
        {{ $transactions->links('pagination::simple-bootstrap-5') }}
      </div>
    </div>

    <!-- Expenses Tab -->
    <div id="expenses" class="tab-content hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 bg-gray-50">
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Tanggal</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Kategori</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Keterangan</th>
              <th class="text-left py-3 px-6 font-semibold text-gray-900 text-sm">Input Oleh</th>
              <th class="text-right py-3 px-6 font-semibold text-gray-900 text-sm">Nominal</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($expenses as $exp)
              <tr class="hover:bg-gray-50">
                <td class="py-3 px-6 text-gray-600 text-sm">{{ Carbon::parse($exp->expense_date)->format('d M Y') }}</td>
                <td class="py-3 px-6 text-sm">
                  <span class="badge 
                    @if($exp->category === 'maintenance') bg-blue-100 text-blue-800
                    @elseif($exp->category === 'utilities') bg-yellow-100 text-yellow-800
                    @elseif($exp->category === 'supplies') bg-purple-100 text-purple-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($exp->category) }}
                  </span>
                </td>
                <td class="py-3 px-6 text-gray-900 text-sm">{{ $exp->description }}</td>
                <td class="py-3 px-6 text-gray-600 text-sm">{{ $exp->user->name ?? 'N/A' }}</td>
                <td class="py-3 px-6 text-right font-semibold text-gray-900 text-sm">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-8 text-center text-gray-500">Tidak ada pengeluaran</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="border-t border-gray-200 px-6 py-4 bg-gray-50 flex justify-between items-center text-sm">
        <span class="text-gray-600">Total: <strong class="text-gray-900">Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}</strong></span>
        {{ $expenses->links('pagination::simple-bootstrap-5', ['paginator' => $expenses]) }}
      </div>
    </div>
  </div>
</div>

  <script>
    // Tab switching with initial active state
    (function(){
      const tabs = document.querySelectorAll('.tab-btn');
      const contents = document.querySelectorAll('.tab-content');

      function activate(index){
        contents.forEach(c => c.classList.add('hidden'));
        tabs.forEach(t => {
          t.classList.remove('border-b-2','border-blue-600','text-blue-600');
          t.classList.add('border-b-2','border-transparent','text-gray-600');
        });
        contents[index].classList.remove('hidden');
        tabs[index].classList.remove('border-transparent','text-gray-600');
        tabs[index].classList.add('border-blue-600','text-blue-600');
      }

      tabs.forEach((btn, i) => {
        btn.addEventListener('click', () => activate(i));
      });

      // Activate first tab by default
      if(tabs.length) activate(0);
    })();
  </script>
@endsection
