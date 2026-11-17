@extends('layouts.app')

@section('title', 'Detail Transaksi - Hotel Nuansa')
@section('page_title', 'Detail Transaksi')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

  <!-- Header with Back Button -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all mb-2">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Riwayat</span>
      </a>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">
        Invoice: <span class="text-[#1D58B8]">{{ $tx->invoice_code }}</span>
      </h2>
    </div>

    <div class="flex items-center gap-3">
      @if($tx->status === 'active')
        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-4 py-1.5 rounded-full shadow-xs">
          <i class="fas fa-clock mr-1"></i> Sedang Menginap (Aktif)
        </span>
        <a href="{{ route('checkin', ['tx_id' => $tx->id]) }}" 
           class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-5 py-2 rounded-full text-xs shadow-md transition-all">
          Proses Checkout
        </a>
      @else
        <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-4 py-1.5 rounded-full shadow-xs">
          <i class="fas fa-check-circle mr-1"></i> Transaksi Selesai
        </span>
        <a href="{{ route('transactions.struk', $tx->id) }}" target="_blank"
           class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-1.5">
          <i class="fas fa-print"></i>
          <span>Cetak Struk</span>
        </a>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- LEFT: Guest & Room Info (Col 7) -->
    <div class="lg:col-span-7 space-y-6">
      
      <!-- Guest Information Card -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-base font-bold text-[#0B192C] flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1D58B8] flex items-center justify-center text-xs">
              <i class="fas fa-user"></i>
            </div>
            <span>Informasi Tamu</span>
          </h3>

          @if(!$tx->is_guest_data_complete)
            <a href="{{ route('transactions.guestBook', $tx->id) }}" 
               class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold text-xs px-4 py-1.5 rounded-full transition-all flex items-center gap-1.5 shadow-xs">
              <i class="fas fa-pen-to-square"></i>
              <span>Lengkapi Data</span>
            </a>
          @else
            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-3 py-1 rounded-full border border-emerald-200">
              ✓ Data Lengkap
            </span>
          @endif
        </div>

        @if(!$tx->is_guest_data_complete)
          <div class="mb-5 p-4 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 text-xs flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
              <i class="fas fa-exclamation-triangle text-amber-500 text-base shrink-0"></i>
              <div>
                <p class="font-bold">Data Identitas Tamu Belum Lengkap!</p>
                <p class="text-amber-700 text-[11px]">Tamu hasil Express Check-in belum mengisi NIK, kontak, atau alamat.</p>
              </div>
            </div>
          </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Nama Lengkap</p>
            <p class="text-sm font-bold text-[#0B192C]">{{ $tx->guest_name }}</p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">NIK / No. KTP</p>
            <p class="text-sm font-semibold text-slate-700">{{ $tx->guest_nik ?: '-' }}</p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">No. Handphone</p>
            <p class="text-sm font-semibold text-slate-700">{{ $tx->guest_phone ?: '-' }}</p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Jaminan Identitas</p>
            <p class="text-sm font-bold text-[#0B192C]">
              {{ $tx->guarantee_type ?: 'KTP' }} 
              <span class="text-[11px] font-normal text-slate-500">
                ({{ $tx->is_ktp_held ? ($tx->guarantee_returned ? 'Sudah Dikembalikan' : 'Sedang Ditahan') : 'Tidak Ditahan' }})
              </span>
            </p>
          </div>
          <div class="sm:col-span-2">
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Alamat</p>
            <p class="text-sm text-slate-700">{{ $tx->guest_address ?: '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Room & Stay Details Card -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <h3 class="text-base font-bold text-[#0B192C] mb-5 flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
            <i class="fas fa-bed"></i>
          </div>
          <span>Informasi Kamar & Menginap</span>
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Kamar</p>
            <p class="text-base font-black text-[#0B192C]">Kamar {{ $tx->room->room_number ?? '-' }}</p>
            <p class="text-slate-500 font-medium">{{ $tx->room->type ?? '-' }}</p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Tarif per Malam</p>
            <p class="text-sm font-extrabold text-[#0B192C]">
              Rp {{ number_format($tx->room->price_per_night ?? 0, 0, ',', '.') }}
            </p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Waktu Check-in</p>
            <p class="text-sm font-bold text-slate-800">
              {{ $tx->check_in ? $tx->check_in->isoFormat('D MMMM YYYY, HH:mm') : '-' }}
            </p>
          </div>
          <div>
            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Waktu Check-out</p>
            <p class="text-sm font-bold text-slate-800">
              {{ $tx->check_out ? $tx->check_out->isoFormat('D MMMM YYYY, HH:mm') : '-' }}
            </p>
          </div>
        </div>
      </div>

    </div>

    <!-- RIGHT: Billing & Settlement (Col 5) -->
    <div class="lg:col-span-5 space-y-6">
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50 flex flex-col justify-between">
        <div>
          <h3 class="text-base font-bold text-[#0B192C] mb-5">Rincian Pembayaran</h3>

          <div class="space-y-3 text-xs divide-y divide-stone-100">
            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Sewa Kamar ({{ $tx->duration }} malam)</span>
              <span class="font-bold text-slate-800">
                Rp {{ number_format(($tx->room->price_per_night ?? 0) * $tx->duration, 0, ',', '.') }}
              </span>
            </div>

            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Biaya Tambahan</span>
              <span class="font-bold text-slate-800">
                Rp {{ number_format($tx->additional_charges ?? 0, 0, ',', '.') }}
              </span>
            </div>

            <div class="flex justify-between items-center py-3 border-t-2 border-stone-200">
              <span class="font-bold text-base text-[#0B192C]">Total Tagihan</span>
              <span class="font-black text-xl text-[#1D58B8]">
                Rp {{ number_format($tx->total_price, 0, ',', '.') }}
              </span>
            </div>

            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Jumlah Dibayar</span>
              <span class="font-extrabold text-slate-800">
                Rp {{ number_format($tx->paid_amount ?? 0, 0, ',', '.') }}
              </span>
            </div>

            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Status Pembayaran</span>
              @if($tx->payment_status === 'paid')
                <span class="bg-[#DCFCE7] text-[#16A34A] font-bold px-3 py-1 rounded-full text-[11px]">Paid (Lunas)</span>
              @elseif($tx->payment_status === 'partial')
                <span class="bg-[#FEF3C7] text-[#D97706] font-bold px-3 py-1 rounded-full text-[11px]">Partial (Sebagian)</span>
              @else
                <span class="bg-rose-100 text-rose-700 font-bold px-3 py-1 rounded-full text-[11px]">Unpaid (Belum Bayar)</span>
              @endif
            </div>

            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Metode Pembayaran</span>
              <span class="font-bold text-slate-800">
                {{ $tx->paymentMethod->bank_name ?? $tx->paymentMethod->name ?? 'Cash' }}
                @if(!empty($tx->paymentMethod->account_number))
                  <span class="text-xs font-normal text-slate-500">({{ $tx->paymentMethod->account_number }})</span>
                @endif
              </span>
            </div>

            <div class="flex justify-between items-center py-2">
              <span class="text-slate-500 font-medium">Kasir Bertugas</span>
              <span class="font-bold text-slate-800">{{ $tx->cashier_name ?? ($tx->user->name ?? '-') }}</span>
            </div>
          </div>
        </div>

        @if($tx->is_tc)
          <div class="mt-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs">
            <span class="font-bold text-amber-800">Komisi TC:</span>
            <span class="text-amber-900 font-extrabold ml-1">Rp {{ number_format($tx->tc_nominal, 0, ',', '.') }}</span>
          </div>
        @endif
      </div>
    </div>
  </div>

</div>
@endsection
