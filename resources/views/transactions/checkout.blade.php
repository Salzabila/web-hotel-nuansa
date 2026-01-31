@extends('layouts.app')

@section('content')
<div class="h-full max-w-4xl mx-auto">
  <!-- Header -->
  <div class="mb-8">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-3 transition">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Beranda</span>
    </a>
    <h1 class="text-3xl font-bold text-slate-800">Konfirmasi Check-out</h1>
    <p class="text-slate-500 mt-2 text-base">Verifikasi data sebelum menyelesaikan transaksi</p>
  </div>
  @if(session('error'))
    <div class="bg-red-50 border-2 border-red-300 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-exclamation-circle text-2xl"></i>
      <span class="font-semibold">{{ session('error') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="bg-red-50 border-2 border-red-300 text-red-800 px-6 py-4 rounded-xl mb-6">
      <div class="flex items-center gap-3 mb-2">
        <i class="fas fa-exclamation-triangle text-2xl"></i>
        <span class="font-bold text-lg">Terjadi Kesalahan Validasi:</span>
      </div>
      <ul class="list-disc list-inside space-y-1 ml-8">
        @foreach($errors->all() as $error)
          <li class="text-sm">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('transactions.processCheckout', $tx->id) }}" class="confirm-form" data-confirm-title="Konfirmasi Checkout" data-confirm-message="Pastikan pembayaran dan pengembalian jaminan sudah benar. Lanjutkan checkout?">
    @csrf
    
    <!-- Guest Information Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
      <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-user text-blue-600 text-lg"></i>
        </div>
        <div>
          <h2 class="text-lg font-bold text-slate-800">Informasi Pelanggan</h2>
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

      <!-- JAMINAN IDENTITAS WARNING -->
      @if($tx->is_ktp_held)
        <div class="mt-6 bg-amber-50 border-2 border-amber-300 rounded-xl p-5">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-exclamation-triangle text-white text-lg"></i>
            </div>
            <div class="flex-1">
              <p class="text-base font-bold text-amber-900 mb-2">⚠️ PERHATIAN - JAMINAN IDENTITAS</p>
              <p class="text-sm text-amber-800 leading-relaxed mb-3">
                Mohon kembalikan <strong>{{ $tx->guarantee_type ?? 'KTP' }} atas nama {{ $tx->guest_name }}</strong> kepada pelanggan sebelum menyelesaikan transaksi ini.
              </p>
              
              <!-- Checkbox Konfirmasi Pengembalian -->
              <div class="bg-white border-2 border-amber-400 rounded-lg p-3 mt-3">
                <div class="flex items-start gap-3">
                  <input type="hidden" name="guarantee_returned" value="0">
                  <input 
                    type="checkbox" 
                    name="guarantee_returned" 
                    id="guarantee_returned" 
                    value="1"
                    class="w-5 h-5 text-amber-600 rounded cursor-pointer mt-0.5 flex-shrink-0" 
                    required>
                  <label for="guarantee_returned" class="text-sm font-bold text-amber-900 cursor-pointer flex-1">
                    ✓ Saya sudah mengembalikan {{ $tx->guarantee_type ?? 'KTP' }} kepada pelanggan
                    <p class="text-xs text-amber-700 font-normal mt-1">
                      Wajib dicentang untuk melanjutkan checkout
                    </p>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="mt-6 bg-slate-50 border border-slate-200 rounded-xl p-4">
          <p class="text-sm text-slate-600 flex items-center gap-2">
            <i class="fas fa-info-circle text-slate-400"></i>
            Tidak ada jaminan identitas untuk transaksi ini.
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
          <span class="text-sm font-bold text-slate-800">{{ $tx->duration }} Malam</span>
        </div>

        <!-- Pricing -->
        <div class="flex justify-between items-center pt-4 border-t border-slate-200">
          <span class="text-sm text-slate-600">Harga per Malam</span>
          <span class="text-sm font-semibold text-slate-800">Rp {{ number_format($tx->room->price_per_night, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-base font-semibold text-slate-800">Subtotal Kamar ({{ $tx->duration }} malam)</span>
          <span class="text-base font-bold text-slate-800">Rp {{ number_format($tx->room->price_per_night * $tx->duration, 0, ',', '.') }}</span>
        </div>

        <!-- Additional Charges Input -->
        <div class="pt-4 border-t border-slate-200">
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            <i class="fas fa-plus-circle text-rose-500 mr-1"></i>
            Biaya Tambahan (Denda/Layanan) 
            <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-2 py-0.5 rounded ml-1">Opsional</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-3.5 text-slate-600 font-semibold z-10">Rp</span>
            <input 
              type="text" 
              id="additionalChargesDisplay"
              value=""
              class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 bg-slate-50 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 focus:bg-white"
              placeholder="0"
              oninput="formatCurrency(this, 'additionalCharges'); calculateTotal()">
            <input type="hidden" name="additional_charges" id="additionalCharges" value="0">
          </div>
          <p class="text-xs text-slate-500 mt-2">
            <i class="fas fa-info-circle mr-1"></i>Contoh: denda kerusakan, minibar, laundry, keterlambatan check-out, dll.
          </p>
        </div>
        
        <!-- Payment Input -->
        <div class="pt-4 border-t border-slate-200">
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            <i class="fas fa-money-bill-wave text-emerald-600 mr-1"></i>
            Jumlah Dibayar 
            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded ml-1">WAJIB DIISI</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-3.5 text-slate-700 font-bold text-lg z-10">Rp</span>
            <input 
              type="text" 
              id="paidAmountDisplay"
              value=""
              class="w-full pl-14 pr-4 py-3 border-3 border-yellow-400 bg-yellow-50 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white text-lg font-semibold"
              placeholder="0"
              oninput="formatCurrency(this, 'paidAmount'); calculateChange()">
            <input type="hidden" name="paid_amount" id="paidAmount" value="0" required>
          </div>
          <p class="text-xs text-emerald-600 mt-2 font-semibold">
            <i class="fas fa-exclamation-circle mr-1"></i>Wajib diisi - Masukkan jumlah uang tunai yang diterima dari pelanggan
          </p>
        </div>
        <!-- Cashier Selection -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            <i class="fas fa-user-tie text-blue-600 mr-1"></i>
            Kasir Bertugas 
            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded ml-1">WAJIB DIISI</span>
          </label>
          <select 
            name="cashier_name" 
            class="w-full px-4 py-3 border-3 border-yellow-400 bg-yellow-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white text-base font-medium"
            required>
            <option value="">-- Pilih Nama Kasir --</option>
            @foreach($cashiers as $cashier)
              <option value="{{ $cashier->name }}" {{ old('cashier_name') == $cashier->name ? 'selected' : '' }}>
                {{ $cashier->name }}
              </option>
            @endforeach
          </select>
          <p class="text-xs text-blue-600 mt-2 font-semibold">
            <i class="fas fa-exclamation-circle mr-1"></i>Wajib diisi - Pilih nama kasir yang melakukan proses checkout ini
          </p>
          @if($cashiers->count() === 0)
            <p class="text-xs text-red-600 mt-2 font-semibold">
              <i class="fas fa-exclamation-triangle mr-1"></i>Belum ada data kasir! Admin harus menambahkan kasir terlebih dahulu.
            </p>
          @endif
        </div>

        <!-- Shift Selection (Flexible) -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">
            <i class="fas fa-clock text-purple-600 mr-1"></i>
            Shift Kerja 
            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded ml-1">WAJIB DIISI</span>
          </label>
          <select 
            name="shift" 
            class="w-full px-4 py-3 border-3 border-yellow-400 bg-yellow-50 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white text-base font-medium"
            required>
            <option value="Pagi" {{ $currentShift === 'Pagi' ? 'selected' : '' }}>☀️ Pagi (07:00 - 19:00)</option>
            <option value="Malam" {{ $currentShift === 'Malam' ? 'selected' : '' }}>🌙 Malam (19:00 - 07:00)</option>
          </select>
          <p class="text-xs text-purple-600 mt-2 font-semibold">
            <i class="fas fa-info-circle mr-1"></i>Otomatis terdeteksi: <strong>{{ $currentShift }}</strong> - Ubah jika perlu sesuai tutup buku
          </p>
        </div>

        <!-- Grand Total -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-200 rounded-xl p-5 mt-4">
          <div class="flex justify-between items-center mb-3">
            <span class="text-lg font-bold text-emerald-900">TOTAL PEMBAYARAN</span>
            <span class="text-2xl font-bold text-emerald-700" id="grandTotal">
              Rp {{ number_format($tx->room->price_per_night * $tx->duration, 0, ',', '.') }}
            </span>
          </div>
          <div class="flex justify-between items-center pt-3 border-t border-emerald-300" id="changeDisplay" style="display: none;">
            <span class="text-sm font-semibold text-emerald-800">Kembalian</span>
            <span class="text-lg font-bold text-emerald-900" id="changeAmount">Rp 0</span>
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
  const pricePerNight = {{ $tx->room->price_per_night }};
  const duration = {{ $tx->duration }};
  const baseSubtotal = pricePerNight * duration;
  
  function formatCurrency(input, hiddenInputId) {
    // Ambil value dan hapus semua karakter non-digit
    let value = input.value.replace(/\D/g, '');
    
    // Update hidden input dengan value asli (tanpa format)
    document.getElementById(hiddenInputId).value = value || '0';
    
    // Format dengan titik separator untuk ribuan
    if (value) {
      value = parseInt(value).toLocaleString('id-ID');
      input.value = value;
    }
  }
  
  function calculateTotal() {
    const additionalCharges = parseInt(document.getElementById('additionalCharges').value) || 0;
    const grandTotal = baseSubtotal + additionalCharges;
    
    document.getElementById('grandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    
    // Recalculate change if payment amount is entered
    calculateChange();
  }
  
  function calculateChange() {
    const additionalCharges = parseInt(document.getElementById('additionalCharges').value) || 0;
    const grandTotal = baseSubtotal + additionalCharges;
    const paidAmount = parseInt(document.getElementById('paidAmount').value) || 0;
    const change = paidAmount - grandTotal;
    
    const changeDisplay = document.getElementById('changeDisplay');
    const changeAmount = document.getElementById('changeAmount');
    
    if (paidAmount > 0) {
      changeDisplay.style.display = 'flex';
      
      if (change >= 0) {
        changeAmount.textContent = 'Rp ' + change.toLocaleString('id-ID');
        changeAmount.classList.remove('text-red-600');
        changeAmount.classList.add('text-emerald-900');
      } else {
        changeAmount.textContent = 'KURANG: Rp ' + Math.abs(change).toLocaleString('id-ID');
        changeAmount.classList.remove('text-emerald-900');
        changeAmount.classList.add('text-red-600');
      }
    } else {
      changeDisplay.style.display = 'none';
    }
  }
  
  // Initialize on page load
  calculateTotal();
</script>
@endsection
