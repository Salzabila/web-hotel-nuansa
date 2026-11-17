@extends('layouts.app')

@section('title', 'Rekapitulasi Shift Saya - Hotel Nuansa')
@section('page_title', 'Shift Saya')

@section('content')
<div class="space-y-6">

  <!-- TOP HEADER -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Rekapitulasi Shift Saya</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">
        Petugas: <strong>{{ $userName }}</strong> | {{ $today->isoFormat('dddd, D MMMM YYYY') }}
      </p>
    </div>

    <!-- Print Button -->
    <button onclick="window.print()" 
            class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2 self-start sm:self-auto">
      <i class="fas fa-print"></i>
      <span>Cetak Laporan Shift</span>
    </button>
  </div>

  <!-- SUMMARY CARDS -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Kas Masuk -->
    <div class="bg-[#1D58B8] text-white rounded-3xl p-6 shadow-sm flex flex-col justify-between">
      <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center text-white mb-2">
        <i class="fas fa-money-bill-wave text-base"></i>
      </div>
      <div>
        <p class="text-xs font-semibold text-blue-100">Total Uang Masuk</p>
        <h3 class="text-2xl md:text-3xl font-black tracking-tight mt-1">
          Rp {{ number_format($totalCashIn, 0, ',', '.') }}
        </h3>
        <p class="text-[11px] text-blue-200 mt-0.5">Uang tunai shift ini</p>
      </div>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between">
      <div class="w-10 h-10 rounded-2xl bg-stone-100 flex items-center justify-center text-slate-600 mb-2">
        <i class="fas fa-receipt text-base"></i>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-400">Total Transaksi</p>
        <h3 class="text-2xl md:text-3xl font-black text-[#0B192C] mt-1">{{ $totalTransactions }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Ditangani oleh Anda</p>
      </div>
    </div>

    <!-- Transaksi Selesai -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between">
      <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-2">
        <i class="fas fa-check-circle text-base"></i>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-400">Checkout Selesai</p>
        <h3 class="text-2xl md:text-3xl font-black text-emerald-600 mt-1">{{ $finishedTransactions }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Tamu sudah selesai</p>
      </div>
    </div>

    <!-- Transaksi Aktif -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50 flex flex-col justify-between">
      <div class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-2">
        <i class="fas fa-bed text-base"></i>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-400">Kamar Masih Aktif</p>
        <h3 class="text-2xl md:text-3xl font-black text-amber-600 mt-1">{{ $activeTransactions }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Sedang menginap</p>
      </div>
    </div>
  </div>

  <!-- TRANSACTIONS TABLE CARD -->
  <div class="bg-white rounded-3xl shadow-sm border border-stone-200/50 overflow-hidden">
    <div class="p-6 border-b border-stone-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-[#0B192C]">Rincian Transaksi Shift Hari Ini</h3>
      <span class="text-xs font-semibold text-slate-400">{{ count($transactions) }} Transaksi</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs md:text-sm">
        <thead class="bg-[#F8F5EF] text-slate-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-6">Invoice</th>
            <th class="py-3.5 px-6">Nama Tamu</th>
            <th class="py-3.5 px-6">Kamar</th>
            <th class="py-3.5 px-6">Waktu Masuk</th>
            <th class="py-3.5 px-6">Durasi</th>
            <th class="py-3.5 px-6">Total Tagihan</th>
            <th class="py-3.5 px-6 text-center">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100 font-medium">
          @forelse($transactions as $tx)
            <tr class="hover:bg-[#FBF9F5] transition-colors">
              <td class="py-4 px-6 font-extrabold text-[#0B192C]">
                {{ $tx->invoice_code }}
              </td>
              <td class="py-4 px-6 font-bold text-slate-800">
                {{ $tx->guest_name }}
              </td>
              <td class="py-4 px-6">
                <span class="bg-stone-100 text-[#0B192C] font-bold px-2.5 py-1 rounded-xl text-xs">
                  {{ $tx->room->room_number ?? '-' }}
                </span>
              </td>
              <td class="py-4 px-6 text-slate-600 text-xs">
                {{ $tx->created_at->format('H:i') }} WIB
              </td>
              <td class="py-4 px-6 text-slate-600 text-xs">
                {{ $tx->duration }} malam
              </td>
              <td class="py-4 px-6 font-black text-[#0B192C]">
                Rp {{ number_format($tx->total_price, 0, ',', '.') }}
              </td>
              <td class="py-4 px-6 text-center">
                @if($tx->status === 'finished')
                  <span class="bg-[#DCFCE7] text-[#16A34A] font-bold px-3 py-1 rounded-full text-[11px]">
                    Selesai
                  </span>
                @else
                  <span class="bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full text-[11px]">
                    Aktif
                  </span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-400 text-xs font-medium">
                Belum ada transaksi yang ditangani pada shift ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
