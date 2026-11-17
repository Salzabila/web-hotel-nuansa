@extends('layouts.app')

@section('title', 'Tanda Terima Check-in - Hotel Nuansa')
@section('page_title', 'Tanda Terima Check-in')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Back button -->
  <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Dashboard</span>
  </a>

  <!-- Receipt Confirmation Card -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
    <div class="text-center pb-6 border-b border-stone-100">
      <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mx-auto mb-3">
        <i class="fas fa-check"></i>
      </div>
      <h3 class="text-xl font-extrabold text-[#0B192C]">Check-in Berhasil</h3>
      <p class="text-xs text-slate-400 mt-0.5">
        Invoice: <span class="text-[#1D58B8] font-bold">{{ $transaction->invoice_code }}</span> | Kamar <strong>{{ $transaction->room->room_number }}</strong>
      </p>
    </div>

    <!-- Summary of transaction -->
    <div class="bg-[#F8F5EF] rounded-2xl p-4 md:p-5 my-6 space-y-2 text-xs">
      <div class="flex justify-between text-slate-600">
        <span>Nama Tamu:</span>
        <strong class="text-slate-800">{{ $transaction->guest_name }}</strong>
      </div>
      <div class="flex justify-between text-slate-600">
        <span>Tipe Kamar:</span>
        <strong class="text-slate-800">{{ $transaction->room->type }}</strong>
      </div>
      <div class="flex justify-between text-slate-600">
        <span>Durasi Menginap:</span>
        <strong class="text-slate-800">{{ $transaction->duration }} Malam</strong>
      </div>
      <div class="flex justify-between items-center pt-2 border-t border-stone-200">
        <span class="text-slate-700 font-bold">Total Biaya Sewa:</span>
        <span class="text-sm font-extrabold text-[#1D58B8]">
          Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
        </span>
      </div>
    </div>

    <!-- Actions -->
    <div class="space-y-3">
      <!-- Struk Button -->
      <a href="{{ route('transactions.struk', $transaction->id) }}" target="_blank"
         class="w-full bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold py-3.5 rounded-full text-xs shadow-md transition-all flex items-center justify-center gap-2 text-center active:scale-95">
        <i class="fas fa-print"></i>
        <span>Cetak Struk Thermal</span>
      </a>

      <!-- Buku Tamu Digital Button -->
      <a href="{{ route('transactions.guestBook', $transaction->id) }}"
         class="w-full bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold py-3 rounded-full text-xs shadow-xs transition-all flex items-center justify-center gap-2 text-center">
        <i class="fas fa-book-open"></i>
        <span>Lengkapi Buku Tamu Digital</span>
      </a>

      <!-- Dashboard Button -->
      <a href="{{ route('dashboard') }}"
         class="w-full text-center block text-xs font-bold text-slate-400 hover:text-slate-600 pt-2 transition-all">
        Selesai & Ke Dashboard
      </a>
    </div>

  </div>

</div>
@endsection
