@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-lg mb-3 transition border-2 border-slate-300">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Beranda</span>
    </a>
    <h1 class="text-3xl font-bold text-slate-800">Check-in Pelanggan Baru</h1>
    <p class="text-slate-500 mt-2 text-base flex items-center gap-2">
      <i class="fas fa-door-open text-blue-600"></i>
      Kamar {{ $room->room_number }} - {{ $room->type }}
    </p>
  </div>

  <!-- Express Check-in Banner -->
  <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
        <i class="fas fa-bolt text-3xl"></i>
      </div>
      <div>
        <h2 class="text-2xl font-bold mb-1">Express Check-in</h2>
        <p class="text-emerald-50 text-sm">Cetak struk dulu, isi buku tamu nanti! Tamu tidak perlu menunggu lama.</p>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('transactions.store', $room->id) }}" enctype="multipart/form-data" id="checkInForm">
    @csrf
    
    <!-- Single Column Layout - Express Check-in -->
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
      
      <!-- Detail Reservasi (Hanya Form Kamar) -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-bed text-emerald-600 text-lg"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-800">Detail Reservasi</h2>
            <p class="text-xs text-slate-500">Informasi kamar & biaya</p>
          </div>
        </div>

        <div class="space-y-5">
          <!-- Info Kamar (Static) -->
          <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200">
            <div class="flex items-center justify-between mb-3">
              <span class="text-sm font-semibold text-slate-700">Nomor Kamar</span>
              <span class="text-2xl font-bold text-blue-700">{{ $room->room_number }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-semibold text-slate-700">Tipe Kamar</span>
              <span class="text-lg font-bold text-blue-900">{{ $room->type }}</span>
            </div>
          </div>

          <!-- Durasi Menginap -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Lama Menginap <span class="text-red-500">*</span>
            </label>
            <select 
              name="duration" 
              id="duration" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-semibold text-slate-800" 
              required 
              onchange="updateTotal()">
              @for($i = 1; $i <= 30; $i++)
                <option value="{{ $i }}" {{ old('duration', 1) == $i ? 'selected' : '' }}>
                  {{ $i }} Malam
                </option>
              @endfor
            </select>
            @error('duration')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
          </div>

          <!-- Kalkulator Harga -->
          <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-5 rounded-xl border-2 border-emerald-200 space-y-3">
            <div class="flex justify-between items-center text-sm">
              <span class="text-slate-700 font-medium">Harga per Malam</span>
              <span class="font-bold text-emerald-900">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span class="text-slate-700 font-medium">Durasi</span>
              <span class="font-bold text-emerald-900">
                <span id="display-duration">1</span> Malam
              </span>
            </div>
            <div class="border-t-2 border-emerald-300 pt-3 flex justify-between items-center">
              <span class="font-bold text-slate-900 text-base">Total Biaya</span>
              <span class="font-bold text-2xl text-emerald-700" id="total">
                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
              </span>
            </div>
          </div>

          <!-- Jaminan Identitas -->
          <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-shield-alt text-amber-600"></i>
              <span class="font-bold text-slate-800">Jaminan Identitas <span class="text-xs text-slate-500">(Opsional)</span></span>
            </div>
            
            <!-- Dropdown Jenis Jaminan -->
            <div class="mb-4">
              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Jenis Jaminan <span class="text-slate-400 text-xs">(Opsional)</span>
              </label>
              <select 
                name="guarantee_type" 
                id="guarantee_type" 
                class="w-full px-4 py-3 border border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-slate-800 font-semibold bg-white">
                <option value="">-- Isi nanti di buku tamu --</option>
                <option value="KTP" {{ old('guarantee_type') == 'KTP' ? 'selected' : '' }}>KTP (Kartu Tanda Penduduk)</option>
                <option value="SIM" {{ old('guarantee_type') == 'SIM' ? 'selected' : '' }}>SIM (Surat Izin Mengemudi)</option>
                <option value="STNK" {{ old('guarantee_type') == 'STNK' ? 'selected' : '' }}>STNK (Surat Tanda Nomor Kendaraan)</option>
              </select>
            </div>

            <!-- Checkbox Konfirmasi Tahan Jaminan -->
            <div class="flex items-start gap-3 bg-white p-3 rounded-lg border border-amber-300">
              <input 
                type="checkbox" 
                name="is_ktp_held" 
                id="is_ktp_held" 
                class="w-5 h-5 text-amber-600 rounded cursor-pointer mt-0.5 flex-shrink-0" 
                {{ old('is_ktp_held') ? 'checked' : '' }}>
              <label for="is_ktp_held" class="text-sm font-medium text-slate-800 cursor-pointer flex-1">
                Tahan jaminan asli selama menginap
                <p class="text-xs text-slate-600 leading-relaxed mt-1">
                  Centang jika pelanggan menyerahkan fisik dokumen sebagai jaminan
                </p>
              </label>
            </div>
          </div>

          <!-- Fitur TC (Makelar) -->
          <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-handshake text-purple-600"></i>
              <span class="font-bold text-slate-800">Komisi Makelar (TC)</span>
            </div>
            
            <!-- Checkbox Via Makelar -->
            <div class="flex items-start gap-3 bg-white p-3 rounded-lg border border-purple-300 mb-3">
              <input 
                type="checkbox" 
                name="is_tc" 
                id="is_tc" 
                class="w-5 h-5 text-purple-600 rounded cursor-pointer mt-0.5 flex-shrink-0" 
                {{ old('is_tc') ? 'checked' : '' }}
                onchange="toggleTCNominal()">
              <label for="is_tc" class="text-sm font-medium text-slate-800 cursor-pointer flex-1">
                Tamu via Makelar/Agen (TC)
                <p class="text-xs text-slate-600 leading-relaxed mt-1">
                  Centang jika tamu dibawa oleh makelar
                </p>
              </label>
            </div>

            <!-- Input Nominal TC (Conditional with Smooth Animation) -->
            <div id="tc_nominal_wrapper" class="hidden overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0; opacity: 0;">
              <label class="block text-sm font-medium text-slate-700 mb-2">
                Nominal Komisi (Rp) <span class="text-red-500">*</span>
              </label>
              
              <!-- Input Group Style -->
              <div class="flex items-stretch rounded-xl overflow-hidden border border-purple-300 focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500 transition-all">
                <!-- Prepend: Currency Label -->
                <div class="flex items-center justify-center bg-slate-100 px-4 border-r border-purple-200">
                  <span class="text-slate-600 font-semibold text-base select-none">Rp</span>
                </div>
                
                <!-- Input Field -->
                <input 
                  type="text" 
                  id="tc_nominal_display" 
                  class="flex-1 px-4 py-3 border-0 focus:outline-none focus:ring-0 text-slate-800 font-semibold bg-white" 
                  placeholder="Masukkan nominal komisi"
                  oninput="formatRupiah(this)">
                  
                <!-- Hidden input for actual value -->
                <input 
                  type="hidden" 
                  name="tc_nominal" 
                  id="tc_nominal" 
                  value="{{ old('tc_nominal', 0) }}">
              </div>
              
              <!-- Privacy Notice with Subtle Badge Style -->
              <div class="mt-2 flex items-start gap-2 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                <i class="fas fa-lock text-amber-600 text-xs mt-0.5 flex-shrink-0"></i>
                <p class="text-xs text-amber-700 leading-relaxed">
                  <span class="font-semibold">Privasi Terjaga:</span> Data ini RAHASIA dan tidak akan tercetak di struk tamu
                </p>
              </div>
            </div>
          </div>
  
          <!-- Metode Pembayaran -->
          <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-credit-card text-blue-600"></i>
              <span class="font-bold text-slate-800">Metode Pembayaran</span>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Pilih Metode Bayar <span class="text-red-500">*</span>
              </label>
              <select 
                name="payment_method_id" 
                id="payment_method_id" 
                class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 font-semibold bg-white" 
                required>
                <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                @foreach($paymentMethods as $method)
                  <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                    {{ $method->bank_name }}
                    @if($method->account_number)
                      - {{ $method->account_number }}
                    @endif
                  </option>
                @endforeach
              </select>
              @error('payment_method_id')
                <span class="block mt-1.5 text-sm text-red-600">
                  <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </span>
              @enderror
            </div>

            <div class="mt-3 flex items-start gap-2 bg-blue-100 border border-blue-300 rounded-lg px-3 py-2">
              <i class="fas fa-info-circle text-blue-600 text-xs mt-0.5 flex-shrink-0"></i>
              <p class="text-xs text-blue-700 leading-relaxed">
                Pilih metode pembayaran yang akan digunakan tamu untuk transaksi ini
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
      <button 
        type="submit" 
        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-5 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-bolt text-2xl"></i>
        <span class="text-xl">Express Check-in - Cetak Struk</span>
      </button>
      <a 
        href="{{ route('dashboard') }}" 
        class="px-8 bg-red-600 hover:bg-red-700 text-white font-bold py-5 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-times-circle text-xl"></i>
        <span class="text-lg">Batal</span>
      </a>
    </div>
  </form>
</div>

<script>
  const pricePerNight = {{ $room->price_per_night }};
  
  function updateTotal() {
    const duration = parseInt(document.getElementById('duration').value) || 1;
    const total = pricePerNight * duration;
    
    // Update total price
    document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    
    // Update duration display
    document.getElementById('display-duration').textContent = duration;
  }

  // Toggle TC Nominal Input with Smooth Animation (slideDown/fadeIn)
  function toggleTCNominal() {
    const isChecked = document.getElementById('is_tc').checked;
    const wrapper = document.getElementById('tc_nominal_wrapper');
    const inputDisplay = document.getElementById('tc_nominal_display');
    const inputHidden = document.getElementById('tc_nominal');
    
    if (isChecked) {
      // Show with smooth animation
      wrapper.classList.remove('hidden');
      // Trigger reflow to enable transition
      wrapper.offsetHeight;
      wrapper.style.maxHeight = '200px';
      wrapper.style.opacity = '1';
      
      inputDisplay.required = true;
      
      // Focus input after animation
      setTimeout(() => {
        inputDisplay.focus();
      }, 300);
    } else {
      // Hide with smooth animation
      wrapper.style.maxHeight = '0';
      wrapper.style.opacity = '0';
      
      inputDisplay.required = false;
      inputDisplay.value = '';
      inputHidden.value = 0;
      
      // Remove hidden class after animation completes
      setTimeout(() => {
        wrapper.classList.add('hidden');
      }, 300);
    }
  }

  // Format Rupiah - Add dots every 3 digits
  function formatRupiah(input) {
    // Get only numbers
    let value = input.value.replace(/\D/g, '');
    
    // Format with dots every 3 digits
    let formatted = '';
    if (value) {
      // Reverse the string to add dots from right to left
      let reversed = value.split('').reverse().join('');
      for (let i = 0; i < reversed.length; i++) {
        if (i > 0 && i % 3 === 0) {
          formatted = '.' + formatted;
        }
        formatted = reversed[i] + formatted;
      }
    }
    
    // Update display input
    input.value = formatted;
    
    // Update hidden input with raw number
    document.getElementById('tc_nominal').value = value || 0;
  }

  // Toggle Guest Data Section (Collapsible)
  function toggleGuestDataSection() {
    const section = document.getElementById('guestDataSection');
    const collapsedInfo = document.getElementById('collapsedInfo');
    const icon = document.getElementById('toggleIcon');
    
    if (section.classList.contains('hidden')) {
      section.classList.remove('hidden');
      collapsedInfo.classList.add('hidden');
      icon.classList.remove('fa-chevron-down');
      icon.classList.add('fa-chevron-up');
    } else {
      section.classList.add('hidden');
      collapsedInfo.classList.remove('hidden');
      icon.classList.remove('fa-chevron-up');
      icon.classList.add('fa-chevron-down');
    }
  }
  
  // Initialize on page load
  updateTotal();
  toggleTCNominal();
  
  // Prevent form resubmission on page back
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
@endsection
