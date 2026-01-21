@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Biaya Operasional</h1>
    <p class="text-slate-500 mt-2 text-base">Kelola pengeluaran operasional hotel</p>
  </div>

  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-check-circle text-xl"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-exclamation-circle text-xl"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

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
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..." class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
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
        <i class="fas fa-redo"></i> Refresh
      </a>
    </div>
  </form>
</div>

<!-- Table Card -->
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Daftar Pengeluaran</h2>
      <p class="text-slate-500 text-sm mt-1">Total: {{ $expenses->count() }} item</p>
    </div>
    <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg">
      <i class="fas fa-plus"></i> Input Pengeluaran
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
          <th class="text-left py-4 px-6 font-bold text-gray-900">Kategori</th>
          <th class="text-left py-4 px-6 font-bold text-gray-900">Deskripsi</th>
          <th class="text-right py-4 px-6 font-bold text-gray-900">Jumlah</th>
          <th class="text-left py-4 px-6 font-bold text-gray-900">Tanggal</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($expenses as $exp)
          <tr class="hover:bg-blue-50 transition-colors duration-150">
            <td class="py-4 px-6">
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
            <td class="py-4 px-6 text-gray-700">{{ $exp->description ?? '-' }}</td>
            <td class="py-4 px-6 text-right font-semibold text-gray-900">Rp {{ number_format($exp->amount,0,',','.') }}</td>
            <td class="py-4 px-6 text-gray-700">{{ $exp->date->format('d M Y') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="py-16 text-center text-slate-500">
              <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
              <p class="text-lg font-medium">Tidak ada pengeluaran</p>
              <p class="text-sm text-slate-400 mt-1">Silakan input pengeluaran baru untuk memulai</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Pagination -->
@if($expenses->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $expenses->links() }}
  </div>
@endif
@endsection
