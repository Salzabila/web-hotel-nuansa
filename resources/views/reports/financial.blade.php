@extends('layouts.app')

@php
  use Carbon\Carbon;
@endphp

@section('content')
<div>
  <div class="mb-8 flex justify-between items-center">
    <div>
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Laporan Keuangan</h1>
      <p class="text-slate-500 mt-1 text-sm">Ringkasan pendapatan dan pengeluaran</p>
    </div>
    <!-- Export Buttons -->
    <div class="flex gap-2">
      <a href="{{ route('export.financial.pdf') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition-all shadow-sm" target="_blank">
        <i class="fas fa-file-pdf"></i>
        <span class="hidden md:inline">PDF</span>
      </a>
      <a href="{{ route('export.financial.excel') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-all shadow-sm">
        <i class="fas fa-file-excel"></i>
        <span class="hidden md:inline">Excel</span>
      </a>
    </div>
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

  <!-- BARIS 1: RINGKASAN UTAMA - 3 Cards Besar -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Pendapatan -->
    <div class="rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="flex items-center gap-2 mb-3">
            <i class="fas fa-wallet text-white text-2xl"></i>
            <p class="text-white text-sm font-semibold uppercase tracking-wide">Total Pendapatan</p>
          </div>
          <p class="text-white text-4xl font-extrabold mb-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
          <p class="text-white opacity-80 text-xs">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</p>
        </div>
        <div class="text-white opacity-20 text-6xl">
          <i class="fas fa-arrow-trend-up"></i>
        </div>
      </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="flex items-center gap-2 mb-3">
            <i class="fas fa-coins text-white text-2xl"></i>
            <p class="text-white text-sm font-semibold uppercase tracking-wide">Total Pengeluaran</p>
          </div>
          <p class="text-white text-4xl font-extrabold mb-2">Rp {{ number_format($operationalCost + $employeeSalary + ($totalTCCommission ?? 0), 0, ',', '.') }}</p>
          <p class="text-white opacity-80 text-xs">Gaji + Operasional + TC</p>
        </div>
        <div class="text-white opacity-20 text-6xl">
          <i class="fas fa-arrow-trend-down"></i>
        </div>
      </div>
    </div>

    <!-- Laba Bersih -->
    <div class="rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1" style="background: linear-gradient(135deg, {{ $netProfit >= 0 ? '#2563eb 0%, #1e40af' : '#dc2626 0%, #b91c1c' }} 100%);">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="flex items-center gap-2 mb-3">
            <i class="fas fa-chart-line text-white text-2xl"></i>
            <p class="text-white text-sm font-bold uppercase tracking-wide">LABA BERSIH</p>
          </div>
          <p class="text-white text-4xl font-black mb-2">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
          <p class="text-white opacity-80 text-xs font-semibold">
            {{ $netProfit >= 0 ? '✓ Profit Positif' : '✗ Mengalami Rugi' }}
          </p>
        </div>
        <div class="text-white opacity-20 text-6xl">
          <i class="fas fa-sack-dollar"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- BARIS 2: DETAIL BREAKDOWN - 4 Cards Kecil -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Biaya Operasional -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-2 border-slate-100 hover:shadow-md hover:border-amber-300 transition-all">
      <div class="flex flex-col items-center text-center">
        <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-bolt text-amber-600 text-2xl"></i>
        </div>
        <p class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-2">Biaya Operasional</p>
        <p class="text-slate-900 text-2xl font-bold mb-1">Rp {{ number_format($operationalCost, 0, ',', '.') }}</p>
        <p class="text-slate-500 text-xs">Listrik / Air</p>
      </div>
    </div>

    <!-- Gaji Karyawan -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-2 border-slate-100 hover:shadow-md hover:border-blue-300 transition-all">
      <div class="flex flex-col items-center text-center">
        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-user-tie text-blue-600 text-2xl"></i>
        </div>
        <p class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-2">Gaji Karyawan</p>
        <p class="text-slate-900 text-2xl font-bold mb-1">Rp {{ number_format($employeeSalary, 0, ',', '.') }}</p>
        <p class="text-slate-500 text-xs">Total Gaji</p>
      </div>
    </div>

    <!-- Komisi TC -->
    <div class="bg-white rounded-xl p-5 shadow-sm border-2 border-slate-100 hover:shadow-md hover:border-purple-300 transition-all">
      <div class="flex flex-col items-center text-center">
        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-handshake text-purple-600 text-2xl"></i>
        </div>
        <p class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-2">
          <i class="fas fa-lock text-xs"></i> Komisi TC
        </p>
        <p class="text-slate-900 text-2xl font-bold mb-1">Rp {{ number_format($totalTCCommission ?? 0, 0, ',', '.') }}</p>
        <p class="text-slate-500 text-xs">Makelar</p>
      </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-5 shadow-sm border-2 border-slate-200 hover:shadow-md transition-all">
      <div class="flex flex-col items-center text-center">
        <div class="w-14 h-14 bg-slate-200 rounded-full flex items-center justify-center mb-3">
          <i class="fas fa-users text-slate-600 text-2xl"></i>
        </div>
        <p class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-2">Total Pelanggan</p>
        <p class="text-slate-900 text-2xl font-bold mb-1">{{ $totalCustomers }}</p>
        <p class="text-slate-500 text-xs">Orang</p>
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
