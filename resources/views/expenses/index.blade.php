@extends('layouts.app')

@section('content')
<div class="h-full">
<!-- Header -->
<div class="flex justify-between items-center mb-8">
  <div>
    <h1 class="text-3xl font-bold text-slate-800">Biaya Operasional</h1>
    <p class="text-slate-500 mt-2 text-base">Kelola pengeluaran operasional hotel</p>
  </div>
  <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-xl">
    <i class="fas fa-plus"></i> Input Pengeluaran
  </a>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <!-- Total Pengeluaran -->
  <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-start justify-between gap-4">
      <div class="flex-1">
        <p class="text-slate-500 text-sm font-medium mb-2">Total Pengeluaran</p>
        <p class="text-3xl font-bold text-slate-800">Rp {{ number_format($expenses->sum('amount'),0,',','.') }}</p>
      </div>
      <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center">
        <i class="fas fa-receipt text-2xl text-rose-500"></i>
      </div>
    </div>
  </div>

  <!-- Pengeluaran Bulan Ini -->
  <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-start justify-between gap-4">
      <div class="flex-1">
        <p class="text-slate-500 text-sm font-medium mb-2">Bulan Ini</p>
        <p class="text-3xl font-bold text-slate-800">
          Rp {{ number_format(\App\Models\Expense::whereYear('date', date('Y'))->whereMonth('date', date('m'))->sum('amount'),0,',','.') }}
        </p>
      </div>
      <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center">
        <i class="fas fa-calendar text-2xl text-indigo-500"></i>
      </div>
    </div>
  </div>

  <!-- Jumlah Item -->
  <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-start justify-between gap-4">
      <div class="flex-1">
        <p class="text-slate-500 text-sm font-medium mb-2">Jumlah Item</p>
        <p class="text-3xl font-bold text-slate-800">{{ $expenses->count() }}</p>
      </div>
      <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
        <i class="fas fa-list text-2xl text-emerald-500"></i>
      </div>
    </div>
  </div>
</div>

<!-- Search & Filter Bar -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
  <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Cari Deskripsi</label>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi pengeluaran..." class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
    <div>
      <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Kategori</label>
      <select name="category" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        <option value="">Semua Kategori</option>
        <option value="maintenance" {{ request('category') === 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
        <option value="utilities" {{ request('category') === 'utilities' ? 'selected' : '' }}>Utilitas</option>
        <option value="supplies" {{ request('category') === 'supplies' ? 'selected' : '' }}>Perlengkapan</option>
        <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
      </select>
    </div>
    <div>
      <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Dari Tanggal</label>
      <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
    <div>
      <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Sampai Tanggal</label>
      <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
    </div>
    <div class="md:col-span-4 flex gap-3">
      <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-md flex items-center gap-2">
        <i class="fas fa-search"></i> Cari
      </button>
      <a href="{{ route('expenses.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all flex items-center gap-2">
        <i class="fas fa-redo"></i> Reset
      </a>
    </div>
  </form>
</div>

<!-- Table Card -->
<div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100">
  <table class="w-full">
    <thead>
      <tr class="border-b border-slate-200">
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Kategori</th>
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Deskripsi</th>
        <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Jumlah</th>
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Tanggal</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($expenses as $exp)
        <tr class="hover:bg-blue-50/50 transition-colors duration-150">
          <td class="px-6 py-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
              @if($exp->category === 'maintenance') bg-amber-50 text-amber-700 border-amber-200
              @elseif($exp->category === 'utilities') bg-blue-50 text-blue-700 border-blue-200
              @elseif($exp->category === 'supplies') bg-purple-50 text-purple-700 border-purple-200
              @else bg-teal-50 text-teal-700 border-teal-200
              @endif">
              <i class="fas 
                @if($exp->category === 'maintenance') fa-tools
                @elseif($exp->category === 'utilities') fa-plug
                @elseif($exp->category === 'supplies') fa-cube
                @else fa-question-circle
                @endif mr-1"></i>
              {{ ucfirst(str_replace('_', ' ', $exp->category)) }}
            </span>
          </td>
          <td class="px-6 py-5 text-slate-700 font-medium">{{ $exp->description ?? '-' }}</td>
          <td class="px-6 py-5 text-right font-bold text-slate-800">Rp {{ number_format($exp->amount,0,',','.') }}</td>
          <td class="px-6 py-5 text-slate-700 font-medium">{{ $exp->date->format('d M Y') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-6 py-16 text-center text-slate-500">
            <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
            <p class="text-lg font-medium">Tidak ada pengeluaran</p>
            <p class="text-sm text-slate-400">Silakan input pengeluaran baru untuk memulai</p>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
@if($expenses->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $expenses->links() }}
  </div>
@endif
@endsection
