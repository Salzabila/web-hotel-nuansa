@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Back Button -->
  <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-lg mb-4 transition border-2 border-slate-300">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Dashboard</span>
  </a>

  <!-- Success Alert -->
  @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-md flex items-center gap-3">
      <i class="fas fa-check-circle text-2xl"></i>
      <p class="font-semibold">{{ session('success') }}</p>
    </div>
  @endif

  <!-- Header -->
  <div class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">Struk Check-in Berhasil</h1>
    <p class="text-slate-500">Invoice: <span class="font-bold text-blue-600">{{ $transaction->invoice_code }}</span></p>
  </div>

  <!-- Receipt Card (Format Struk) -->
  <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden mb-6">
    <div class="p-6" id="printArea" style="font-family: 'Courier New', monospace; font-size: 13px;">
      
      @php
        $durationDays = $transaction->duration;
        $subtotal = $transaction->room->price_per_night * $durationDays;
        $grandTotal = $transaction->total_price;
      @endphp

      <!-- Logo -->
      <div class="text-center mb-4">
        <img src="{{ asset('images/logo nuansa.jpg') }}" alt="Nuansa Hotel" style="width: 140px; height: auto; margin: 0 auto;">
      </div>

      <div class="text-center text-xs mb-2">Jl. Letjen Sutoyo No. 59-60</div>
      <div class="text-center text-xs mb-3">Medaeng - Waru - Sidoarjo</div>

      <div style="border-top: 1px solid #000; margin: 8px 0;"></div>

      <!-- Invoice & Shift -->
      <div class="flex justify-between text-sm mb-1">
        <span class="font-bold">{{ $transaction->invoice_code }}</span>
        <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
      </div>
      <div class="text-sm mb-2">Shift : Pagi</div>

      <div style="border-top: 1px solid #000; margin: 8px 0;"></div>

      <!-- Guest & Room Info -->
      <table class="w-full text-sm mb-3">
        <tr><td class="w-24">Pelanggan</td><td>: <span class="font-bold">{{ strtoupper($transaction->guest_name) }}</span></td></tr>
        <tr><td>Kamar</td><td>: <span class="font-bold">{{ $transaction->room->room_number }}</span> - {{ $transaction->room->type }}</td></tr>
      </table>

      <!-- Check-in/out Details -->
      <table class="w-full text-xs mb-3">
        <tr><td class="w-24">Check-in</td><td>: {{ $transaction->check_in->format('d/m/Y') }} ({{ $transaction->check_in->format('H:i') }})</td></tr>
        <tr><td>Check-out</td><td>: {{ $transaction->check_out->format('d/m/Y') }} ({{ $transaction->check_out->format('H:i') }})</td></tr>
        <tr><td>Waktu</td><td>: {{ $durationDays }} malam</td></tr>
        <tr><td>Metode</td><td>: <span class="font-bold">{{ $transaction->paymentMethod->bank_name ?? 'Cash' }}</span></td></tr>
      </table>

      <div style="border-top: 1px solid #000; margin: 8px 0;"></div>

      <!-- Items -->
      <table class="w-full text-sm mb-2">
        <tr>
          <td class="w-8">{{ $durationDays }}</td>
          <td>Kamar {{ $transaction->room->room_number }}</td>
          <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
      </table>

      <div style="border-top: 1px solid #000; margin: 8px 0;"></div>

      <!-- Subtotal -->
      <div class="flex justify-between text-sm mb-2">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
      </div>

      <div style="border-top: 1px dashed #000; margin: 8px 0;"></div>

      <!-- Harga per malam -->
      <div class="text-xs italic text-gray-600 mb-2">Harga per malam: Rp {{ number_format($transaction->room->price_per_night, 0, ',', '.') }}</div>

      <!-- TOTAL -->
      <div class="flex justify-between font-bold text-base mb-3">
        <span>TOTAL</span>
        <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
      </div>

      <div style="border-top: 1px solid #000; margin: 8px 0;"></div>

      <!-- Payment Status -->
      <div class="text-center font-bold py-3 mb-3" style="border: 1px solid #000;">
        BELUM DIBAYAR
      </div>

      <!-- Kasir -->
      <div class="text-center text-xs mb-3">
        Kasir: <span class="font-bold">{{ $transaction->user->name }}</span>
      </div>

      <!-- Footer -->
      <div class="text-center text-xs mb-2">Barang hilang/rusak bukan tanggung jawab kami</div>
      <div class="text-center text-xs mb-3">Simpan struk ini sebagai bukti pembayaran</div>
      <div class="text-center text-xs mb-2">CS: 0889-9429-8505 / 0812-1543-0838</div>
      <div class="text-center font-bold text-sm">TERIMA KASIH</div>

    </div>
  </div>

  <!-- Action Buttons -->
  <div class="max-w-2xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4 mb-8" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
    <!-- Print Button -->
    <button 
      onclick="window.print()" 
      style="background: #4f46e5; color: #ffffff; font-weight: bold; padding: 1rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 2px solid #3730a3; cursor: pointer;">
      <i class="fas fa-print" style="font-size: 1.25rem; color: #ffffff;"></i>
      <span style="color: #ffffff;">Cetak Struk</span>
    </button>

    <!-- Guest Book Button (Prominent if data incomplete) -->
    @if(!$transaction->is_guest_data_complete)
      <a 
        href="{{ route('transactions.guestBook', $transaction->id) }}" 
        style="grid-column: span 2; background: #f97316; color: #ffffff; font-weight: bold; padding: 1rem; border-radius: 0.75rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 4px solid #c2410c; text-decoration: none; animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;">
        <i class="fas fa-book" style="font-size: 1.25rem; color: #ffffff;"></i>
        <span style="font-size: 1.125rem; color: #ffffff;">Isi Buku Tamu Sekarang</span>
        <i class="fas fa-exclamation-circle" style="color: #ffffff;"></i>
      </a>
    @else
      <a 
        href="{{ route('transactions.guestBook', $transaction->id) }}" 
        style="grid-column: span 2; background: #9333ea; color: #ffffff; font-weight: bold; padding: 1rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 2px solid #6b21a8; text-decoration: none;">
        <i class="fas fa-book" style="font-size: 1.25rem; color: #ffffff;"></i>
        <span style="color: #ffffff;">Lihat Buku Tamu</span>
      </a>
    @endif

    <!-- Back to Dashboard -->
    <a 
      href="{{ route('dashboard') }}" 
      style="background: #059669; color: #ffffff; font-weight: bold; padding: 1rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 2px solid #047857; text-decoration: none;">
      <i class="fas fa-home" style="font-size: 1.25rem; color: #ffffff;"></i>
      <span style="color: #ffffff;">Ke Beranda</span>
    </a>
  </div>
</div>

<!-- Print Styles -->
<style>
  /* Force button colors - Override all CSS */
  button[onclick="window.print()"] {
    background: #4f46e5 !important;
    background-color: #4f46e5 !important;
    color: #ffffff !important;
    border: 2px solid #3730a3 !important;
  }
  
  button[onclick="window.print()"] * {
    color: #ffffff !important;
  }
  
  a[href*="guestBook"] {
    background: #f97316 !important;
    background-color: #f97316 !important;
    color: #ffffff !important;
    border: 4px solid #c2410c !important;
  }
  
  a[href*="guestBook"] * {
    color: #ffffff !important;
  }
  
  a[href*="dashboard"] {
    background: #059669 !important;
    background-color: #059669 !important;
    color: #ffffff !important;
    border: 2px solid #047857 !important;
  }
  
  a[href*="dashboard"] * {
    color: #ffffff !important;
  }

  @media print {
    body * {
      visibility: hidden;
    }
    #printArea, #printArea * {
      visibility: visible;
    }
    #printArea {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }
    .no-print {
      display: none !important;
    }
  }
</style>
@endsection
