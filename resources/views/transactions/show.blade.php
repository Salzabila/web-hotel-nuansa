@extends('layouts.app')

@section('content')
<div class="h-full max-w-6xl mx-auto">
  <!-- Header with Back Button -->
  <div class="mb-8 flex items-center justify-between">
    <div>
      <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-3 transition">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Transaksi</span>
      </a>
      <h1 class="text-3xl font-bold text-slate-800">Detail Transaksi</h1>
      <p class="text-slate-500 mt-2 text-base">Invoice: <span class="font-semibold text-blue-600">{{ $tx->invoice_code }}</span></p>
    </div>
    
    <!-- Status Badge -->
    <div>
      @if($tx->status === 'active')
        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-emerald-50 text-emerald-700 border-2 border-emerald-200">
          <i class="fas fa-clock mr-2"></i>Aktif
        </span>
      @else
        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-700 border-2 border-slate-300">
          <i class="fas fa-check-circle mr-2"></i>Selesai
        </span>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- LEFT COLUMN: Guest & Room Info -->
    <div class="lg:col-span-2 space-y-6">
      
      <!-- Guest Information Card -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-user text-blue-600 text-lg"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800">Informasi Tamu</h2>
        </div>

        <div class="grid grid-cols-2 gap-6">
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">Nama Lengkap</p>
            <p class="text-base font-bold text-slate-800">{{ $tx->guest_name }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">NIK / No. KTP</p>
            <p class="text-base font-semibold text-slate-700">{{ $tx->guest_nik }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">No. Handphone</p>
            <p class="text-base font-semibold text-slate-700">{{ $tx->guest_phone ?? '-' }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">Status Jaminan</p>
            @if($tx->is_ktp_held)
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                <i class="fas fa-shield-alt mr-1"></i>KTP Ditahan
              </span>
            @else
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                <i class="fas fa-times-circle mr-1"></i>Tidak Ada
              </span>
            @endif
          </div>
        </div>

        @if($tx->guest_address)
          <div class="mt-6 pt-6 border-t border-slate-100">
            <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider">Alamat Domisili</p>
            <p class="text-sm text-slate-700 leading-relaxed">{{ $tx->guest_address }}</p>
          </div>
        @endif

        <!-- KTP Photo Preview -->
        @if($tx->ktp_photo_path)
          <div class="mt-6 pt-6 border-t border-slate-100">
            <p class="text-xs text-slate-500 mb-3 uppercase tracking-wider">Foto KTP</p>
            <img 
              src="{{ asset('storage/' . $tx->ktp_photo_path) }}" 
              alt="KTP {{ $tx->guest_name }}"
              class="w-full max-w-md rounded-xl border-2 border-slate-200 shadow-md">
          </div>
        @endif
      </div>

      <!-- Room Information Card -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-bed text-teal-600 text-lg"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800">Informasi Kamar</h2>
        </div>

        <div class="grid grid-cols-3 gap-6">
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">Nomor Kamar</p>
            <p class="text-2xl font-bold text-slate-800">{{ $tx->room->room_number }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">Tipe Kamar</p>
            <p class="text-base font-bold text-slate-800">{{ $tx->room->type }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1 uppercase tracking-wider">Harga/Malam</p>
            <p class="text-base font-semibold text-slate-700">Rp {{ number_format($tx->room->price_per_night, 0, ',', '.') }}</p>
          </div>
        </div>
      </div>

      <!-- Timeline Card -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-history text-indigo-600 text-lg"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800">Timeline</h2>
        </div>

        <div class="relative pl-8 space-y-6">
          <!-- Timeline Line -->
          <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-slate-200"></div>

          <!-- Check-in -->
          <div class="relative">
            <div class="absolute -left-8 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-md flex items-center justify-center">
              <i class="fas fa-sign-in-alt text-white text-xs"></i>
            </div>
            <div>
              <p class="text-sm font-bold text-slate-800">Check-in</p>
              <p class="text-sm text-slate-600 mt-1">{{ $tx->check_in->format('l, d F Y - H:i') }} WIB</p>
              <p class="text-xs text-slate-500 mt-1">Petugas: {{ $tx->user->name }}</p>
            </div>
          </div>

          <!-- Check-out -->
          <div class="relative">
            <div class="absolute -left-8 w-6 h-6 {{ $tx->status === 'finished' ? 'bg-blue-500' : 'bg-slate-300' }} rounded-full border-4 border-white shadow-md flex items-center justify-center">
              <i class="fas fa-sign-out-alt text-white text-xs"></i>
            </div>
            <div>
              <p class="text-sm font-bold text-slate-800">Check-out</p>
              @if($tx->status === 'finished' && $tx->check_out)
                <p class="text-sm text-slate-600 mt-1">{{ $tx->check_out->format('l, d F Y - H:i') }} WIB</p>
                <p class="text-xs text-emerald-600 font-semibold mt-1">
                  <i class="fas fa-check-circle mr-1"></i>Transaksi Selesai
                </p>
              @else
                <p class="text-sm text-slate-500 mt-1">Rencana: {{ $tx->check_out->format('l, d F Y') }}</p>
                <p class="text-xs text-amber-600 font-semibold mt-1">
                  <i class="fas fa-clock mr-1"></i>Masih Menginap
                </p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN: Payment Summary -->
    <div class="space-y-6">
      
      <!-- Payment Summary Card -->
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl border-2 border-blue-200 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-file-invoice-dollar text-white text-lg"></i>
          </div>
          <h2 class="text-lg font-bold text-blue-900">Rincian Biaya</h2>
        </div>

        <div class="space-y-4">
          <div class="flex justify-between items-center">
            <span class="text-sm text-blue-800">Durasi Menginap</span>
            <span class="text-sm font-bold text-blue-900">{{ $tx->check_in->diffInDays($tx->check_out) }} Malam</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-blue-800">Harga per Malam</span>
            <span class="text-sm font-semibold text-blue-900">Rp {{ number_format($tx->room->price_per_night, 0, ',', '.') }}</span>
          </div>
          
          <div class="border-t-2 border-blue-300 pt-4">
            <div class="flex justify-between items-center">
              <span class="text-base font-bold text-blue-900">TOTAL</span>
              <span class="text-2xl font-bold text-blue-700">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Actions Card -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Aksi</h3>
        <div class="space-y-3">
          <a href="{{ route('transactions.struk', $tx->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all shadow-md">
            <i class="fas fa-print"></i>
            Cetak Struk
          </a>
          
          @if($tx->status === 'active')
            <a href="{{ route('transactions.checkout', $tx->id) }}" class="w-full flex items-center justify-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-3 rounded-xl transition-all shadow-md">
              <i class="fas fa-sign-out-alt"></i>
              Check-out
            </a>
          @endif
        </div>
      </div>

      <!-- Info Box -->
      <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
        <p class="text-xs text-slate-600 leading-relaxed">
          <i class="fas fa-info-circle text-slate-400 mr-1"></i>
          Transaksi ini dibuat pada {{ $tx->created_at->format('d F Y') }} pukul {{ $tx->created_at->format('H:i') }} WIB
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
