@extends('layouts.app')

@section('content')
<div class="h-full max-w-4xl mx-auto">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Konfirmasi Check-out</h1>
    <p class="text-slate-500 mt-2 text-base">Verifikasi data sebelum menyelesaikan transaksi</p>
  </div>

  <form method="POST" action="{{ route('transactions.processCheckout', $tx->id) }}" onsubmit="return confirm('Yakin ingin menyelesaikan check-out untuk {{ $tx->guest_name }}?\n\nProses ini tidak dapat dibatalkan.')">
    @csrf
    
    <!-- Guest Information Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
      <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-user text-blue-600 text-lg"></i>
        </div>
        <div>
          <h2 class="text-lg font-bold text-slate-800">Informasi Tamu</h2>
          <p class="text-xs text-slate-500">Invoice: <span class="font-semibold text-blue-600">{{ $tx->invoice_code }}</span></p>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
          <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
          <p class="text-base font-bold text-slate-800">{{ $tx->guest_name }}</p>
        </div>
        <div>
          <p class="text-xs text-slate-500 mb-1">NIK / No. KTP</p>
          <p class="text-base font-semibold text-slate-700">{{ $tx->guest_nik }}</p>
        </div>
        <div>
          <p class="text-xs text-slate-500 mb-1">No. Handphone</p>
          <p class="text-base font-semibold text-slate-700">{{ $tx->guest_phone ?? '-' }}</p>
        </div>
        <div>
          <p class="text-xs text-slate-500 mb-1">Kamar</p>
          <p class="text-base font-bold text-slate-800">{{ $tx->room->room_number }} - {{ $tx->room->type }}</p>
        </div>
      </div>

      @if($tx->guest_address)
        <div class="mt-4 pt-4 border-t border-slate-100">
          <p class="text-xs text-slate-500 mb-1">Alamat</p>
          <p class="text-sm text-slate-700">{{ $tx->guest_address }}</p>
        </div>
      @endif

      <!-- KTP WARNING -->
      @if($tx->is_ktp_held)
        <div class="mt-6 bg-amber-50 border-2 border-amber-300 rounded-xl p-5">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-exclamation-triangle text-white text-lg"></i>
            </div>
            <div class="flex-1">
              <p class="text-base font-bold text-amber-900 mb-2">⚠️ PERHATIAN - JAMINAN KTP</p>
              <p class="text-sm text-amber-800 leading-relaxed">
                Mohon kembalikan <strong>KTP atas nama {{ $tx->guest_name }}</strong> kepada tamu sebelum menyelesaikan transaksi ini.
              </p>
            </div>
          </div>
        </div>
      @else
        <div class="mt-6 bg-slate-50 border border-slate-200 rounded-xl p-4">
          <p class="text-sm text-slate-600 flex items-center gap-2">
            <i class="fas fa-info-circle text-slate-400"></i>
            Tidak ada jaminan KTP untuk transaksi ini.
          </p>
        </div>
      @endif
    </div>

    <!-- Bill Summary Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
      <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-file-invoice-dollar text-emerald-600 text-lg"></i>
        </div>
        <div>
          <h2 class="text-lg font-bold text-slate-800">Rincian Biaya</h2>
          <p class="text-xs text-slate-500">Detail pembayaran</p>
        </div>
      </div>

      <div class="space-y-4">
        <!-- Check-in/out dates -->
        <div class="flex justify-between items-center">
          <span class="text-sm text-slate-600">Check-in</span>
          <span class="text-sm font-semibold text-slate-800">{{ $tx->check_in->format('d M Y, H:i') }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-sm text-slate-600">Rencana Check-out</span>
          <span class="text-sm font-semibold text-slate-800">{{ $tx->check_out->format('d M Y, H:i') }}</span>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-slate-100">
          <span class="text-sm text-slate-600">Durasi Menginap</span>
          <span class="text-sm font-bold text-slate-800">{{ $tx->check_in->diffInDays($tx->check_out) }} Malam</span>
        </div>

        <!-- Pricing -->
        <div class="flex justify-between items-center pt-4 border-t border-slate-200">
          <span class="text-sm text-slate-600">Harga per Malam</span>
          <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($tx->room->price_per_night, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-base font-semibold text-slate-800">Subtotal Kamar</span>
          <span class="text-base font-bold text-slate-800">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</span>
        </div>

        <!-- Penalty Input (Optional) -->
        <div class="pt-4 border-t border-slate-200">
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            Denda / Biaya Tambahan <span class="text-slate-400 text-xs font-normal">(Opsional)</span>
          </label>
          <input 
            type="number" 
            name="penalty" 
            id="penalty"
            value="{{ old('penalty', 0) }}"
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
            placeholder="Masukkan jumlah denda (jika ada)"
            min="0"
            oninput="calculateTotal()">
          <p class="text-xs text-slate-500 mt-2">
            <i class="fas fa-info-circle mr-1"></i>Contoh: kerusakan barang, keterlambatan check-out, dll.
          </p>
        </div>

        <!-- Grand Total -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-200 rounded-xl p-5 mt-4">
          <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-emerald-900">TOTAL PEMBAYARAN</span>
            <span class="text-2xl font-bold text-emerald-700" id="grandTotal">
              Rp {{ number_format($tx->total_price, 0, ',', '.') }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
      <button 
        type="submit" 
        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-check-circle text-xl"></i>
        <span class="text-lg">Selesaikan Check-out & Cetak Struk</span>
      </button>
      <a 
        href="{{ route('dashboard') }}" 
        class="px-8 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-times-circle text-xl"></i>
        <span class="text-lg">Batal</span>
      </a>
    </div>
  </form>
</div>

<script>
  const baseTotal = {{ $tx->total_price }};
  
  function calculateTotal() {
    const penalty = parseInt(document.getElementById('penalty').value) || 0;
    const grandTotal = baseTotal + penalty;
    
    document.getElementById('grandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
  }
  
  // Initialize on page load
  calculateTotal();
</script>
@endsection
