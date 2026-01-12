@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Laporan Keuangan</h1>
    <p class="text-gray-500 mt-1 text-sm">Rekapitulasi keuangan hotel</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow-md mb-6">
    <form method="GET" action="{{ route('reports.finance') }}" class="flex gap-3">
      <input type="month" name="month" value="{{ $month }}" class="border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      <button class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 py-2 rounded-lg transition-all shadow-md hover:shadow-lg">
        <i class="fas fa-search mr-2"></i>Cari
      </button>
    </form>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-green-50 to-green-100 border-l-4 border-green-500 p-6 rounded-xl shadow-md">
      <div class="text-xs text-green-700 font-bold uppercase tracking-wider mb-2">Total Pemasukan</div>
      <div class="text-5xl font-black text-green-900">Rp {{ number_format($income,0,',','.') }}</div>
    </div>
    <div class="bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-500 p-6 rounded-xl shadow-md">
      <div class="text-xs text-red-700 font-bold uppercase tracking-wider mb-2">Total Pengeluaran</div>
      <div class="text-5xl font-black text-red-900">Rp {{ number_format($expense,0,',','.') }}</div>
    </div>
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-500 p-6 rounded-xl shadow-md">
      <div class="text-xs text-blue-700 font-bold uppercase tracking-wider mb-2">Saldo Bersih</div>
      <div class="text-5xl font-black text-blue-900">Rp {{ number_format($income - $expense,0,',','.') }}</div>
    </div>
  </div>

  <div class="bg-white p-4 rounded-xl shadow-md">
    <p class="text-sm text-gray-600"><i class="fas fa-calendar mr-2"></i>Periode: {{ \Carbon\Carbon::parse($month.'-01')->format('F Y') }}</p>
  </div>
</div>
@endsection
