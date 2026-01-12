@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8 flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-slate-800"><i class="fas fa-calendar-day mr-2 text-blue-600"></i>Rekapitulasi Harian</h1>
      <p class="text-slate-500 mt-2 text-base">Laporan transaksi harian hotel</p>
    </div>
    <a href="{{ route('recaps.exportDaily', ['date' => $date]) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-green-600/20 hover:shadow-xl">
      <i class="fas fa-download"></i>Export CSV
    </a>
  </div>

  <!-- Date Picker -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" action="{{ route('recaps.daily') }}" class="flex gap-3">
      <input type="date" name="date" value="{{ $date }}" class="border border-slate-300 px-4 py-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-xl">
        <i class="fas fa-search mr-2"></i>Cari
      </button>
    </form>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <div class="text-sm text-slate-500 font-medium mb-2">Total Pemasukan</div>
          <div class="text-3xl font-bold text-slate-800">Rp {{ number_format($income, 0, ',', '.') }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-arrow-up text-2xl text-emerald-500"></i>
        </div>
      </div>
    </div>
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <div class="text-sm text-slate-500 font-medium mb-2">Total Pengeluaran</div>
          <div class="text-3xl font-bold text-slate-800">Rp {{ number_format($expense, 0, ',', '.') }}</div>
        </div>
        <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-arrow-down text-2xl text-rose-500"></i>
        </div>
      </div>
    </div>
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <div class="text-sm text-slate-500 font-medium mb-2">Profit/Rugi</div>
          <div class="text-3xl font-bold" style="color: {{ $profit >= 0 ? '#0f766e' : '#991b1b' }}">
            Rp {{ number_format($profit, 0, ',', '.') }}
          </div>
        </div>
        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-chart-line text-2xl text-blue-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Transactions -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    <div class="border-b border-slate-200 p-5">
      <h2 class="text-lg font-semibold text-slate-800"><i class="fas fa-receipt mr-2 text-blue-600"></i>Transaksi ({{ count($transactions) }})</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Tamu</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">NIK</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Kamar</th>
            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Total</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($transactions as $tx)
            <tr class="hover:bg-slate-50 transition-colors duration-150">
              <td class="px-6 py-4 text-slate-800 font-medium">{{ $tx->guest_name }}</td>
              <td class="px-6 py-4 text-slate-600 text-sm">{{ $tx->nik }}</td>
              <td class="px-6 py-4"><span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">{{ $tx->room->room_number }}</span></td>
              <td class="px-6 py-4 text-right text-slate-800 font-semibold">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
            </tr>
          @empty
            <tr><td colspan="4" class="px-6 py-16 text-center text-slate-500">Tidak ada transaksi hari ini.</td></tr>
          @endforelse
          @if(count($transactions) > 0)
            <tr class="bg-blue-50 border-t-2 border-blue-200">
              <td colspan="3" class="px-6 py-4 text-right text-blue-900 font-bold">Total Transaksi:</td>
              <td class="px-6 py-4 text-right text-blue-900 font-bold text-lg">Rp {{ number_format($income, 0, ',', '.') }}</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>

  <!-- Expenses -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-200 p-5">
      <h2 class="text-lg font-semibold text-slate-800"><i class="fas fa-coins mr-2 text-rose-600"></i>Pengeluaran ({{ count($expenses) }})</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Kategori</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Deskripsi</th>
            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Jumlah</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($expenses as $exp)
            <tr class="hover:bg-slate-50 transition-colors duration-150">
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
                  @if($exp->category === 'maintenance') bg-amber-50 text-amber-700 border-amber-200
                  @elseif($exp->category === 'utilities') bg-blue-50 text-blue-700 border-blue-200
                  @elseif($exp->category === 'supplies') bg-purple-50 text-purple-700 border-purple-200
                  @else bg-teal-50 text-teal-700 border-teal-200
                  @endif">
                  {{ ucfirst(str_replace('_', ' ', $exp->category)) }}
                </span>
              </td>
              <td class="px-6 py-4 text-slate-700 font-medium">{{ $exp->description ?? '-' }}</td>
              <td class="px-6 py-4 text-right text-slate-800 font-semibold">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
            </tr>
          @empty
            <tr><td colspan="3" class="px-6 py-16 text-center text-slate-500">Tidak ada pengeluaran hari ini.</td></tr>
          @endforelse
          @if(count($expenses) > 0)
            <tr class="bg-blue-50 border-t-2 border-blue-200">
              <td colspan="2" class="px-6 py-4 text-right text-blue-900 font-bold">Total Pengeluaran:</td>
              <td class="px-6 py-4 text-right text-blue-900 font-bold text-lg">Rp {{ number_format($expense, 0, ',', '.') }}</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
