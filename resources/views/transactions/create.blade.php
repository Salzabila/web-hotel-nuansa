@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-3 transition">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Beranda</span>
    </a>
    <h1 class="text-3xl font-bold text-slate-800">Check-in Pelanggan Baru</h1>
    <p class="text-slate-500 mt-2 text-base flex items-center gap-2">
      <i class="fas fa-door-open text-blue-600"></i>
      Kamar {{ $room->room_number }} - {{ $room->type }}
    </p>
  </div>

  <form method="POST" action="{{ route('transactions.store', $room->id) }}" enctype="multipart/form-data" id="checkInForm">
    @csrf
    
    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      
      <!-- LEFT COLUMN: Data Identitas -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-id-card text-blue-600 text-lg"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-800">Informasi Pelanggan</h2>
            <p class="text-xs text-slate-500">Sesuai Kartu Identitas (KTP)</p>
          </div>
        </div>

        <div class="space-y-4">
          <!-- NIK -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              NIK / No. KTP <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              name="guest_nik" 
              value="{{ old('guest_nik') }}" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('guest_nik') ? 'border-red-500' : '' }}" 
              placeholder="16 digit NIK"
              maxlength="16"
              pattern="[0-9]{16}"
              required>
            @error('guest_nik')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
          </div>

          <!-- Nama Lengkap -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              name="guest_name" 
              value="{{ old('guest_name') }}" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('guest_name') ? 'border-red-500' : '' }}" 
              placeholder="Nama sesuai KTP"
              style="text-transform: uppercase;"
              required>
            @error('guest_name')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
          </div>

          <!-- Alamat Asal -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Alamat Asal (Kota/Kabupaten) <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              name="guest_phone" 
              value="{{ old('guest_phone') }}" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('guest_phone') ? 'border-red-500' : '' }}" 
              placeholder="Contoh: Surabaya, Sidoarjo, Malang"
              required>
            @error('guest_phone')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
          </div>

          <!-- Alamat -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Alamat Domisili
            </label>
            <textarea 
              name="guest_address" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
              rows="3" 
              placeholder="Alamat lengkap sesuai KTP">{{ old('guest_address') }}</textarea>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: Detail Reservasi -->
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

          <!-- Jaminan KTP -->
          <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
            <div class="flex items-start gap-3">
              <input 
                type="checkbox" 
                name="is_ktp_held" 
                id="is_ktp_held" 
                class="w-6 h-6 text-amber-600 rounded-lg cursor-pointer mt-0.5 flex-shrink-0" 
                {{ old('is_ktp_held') ? 'checked' : '' }}>
              <label for="is_ktp_held" class="text-sm font-medium text-slate-800 cursor-pointer flex-1">
                <div class="flex items-center gap-2 mb-1">
                  <i class="fas fa-shield-alt text-amber-600"></i>
                  <span class="font-bold">Tahan KTP/SIM Asli sebagai Jaminan</span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                  Centang jika pelanggan menyerahkan fisik KTP/SIM sebagai jaminan selama menginap
                </p>
              </label>
            </div>
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
        <span class="text-lg">Proses Check-in</span>
      </button>
      <a 
        href="{{ route('dashboard') }}" 
        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
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
  
  // Initialize on page load
  updateTotal();
  
  // Prevent form resubmission on page back
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
@endsection
