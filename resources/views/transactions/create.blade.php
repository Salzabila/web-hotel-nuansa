@extends('layouts.app')

@section('content')
<div class="h-full" x-data="checkInForm()">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Check-in Tamu Baru</h1>
    <p class="text-slate-500 mt-2 text-base flex items-center gap-2">
      <i class="fas fa-door-open text-blue-600"></i>
      Kamar {{ $room->room_number }} - {{ $room->type }}
    </p>
  </div>

  <form method="POST" action="{{ route('transactions.store', $room->id) }}" enctype="multipart/form-data" id="checkInForm" @submit.prevent="showConfirmModal()">
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
            <h2 class="text-lg font-bold text-slate-800">Informasi Tamu</h2>
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

          <!-- No. Handphone -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              No. Handphone / WhatsApp <span class="text-red-500">*</span>
            </label>
            <input 
              type="tel" 
              name="guest_phone" 
              value="{{ old('guest_phone') }}" 
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('guest_phone') ? 'border-red-500' : '' }}" 
              placeholder="08xxxxxxxxxx"
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

          <!-- Upload Foto KTP (Optional) -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Upload Foto KTP <span class="text-slate-400 text-xs">(Opsional)</span>
            </label>
            <input 
              type="file" 
              name="ktp_photo" 
              accept="image/*"
              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            <p class="text-xs text-slate-500 mt-1.5">
              <i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG (Max 2MB)
            </p>
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
            <div class="flex items-center gap-3">
              <input 
                type="number" 
                name="duration" 
                id="duration" 
                class="flex-1 px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-semibold text-slate-800" 
                min="1" 
                value="{{ old('duration', 1) }}" 
                required 
                oninput="updateTotal()">
              <span class="text-slate-700 font-semibold whitespace-nowrap bg-slate-100 px-4 py-3 rounded-xl">
                Malam
              </span>
            </div>
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
                  <span class="font-bold">Tahan KTP Asli sebagai Jaminan</span>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                  Centang jika tamu menyerahkan fisik KTP sebagai jaminan selama menginap
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

  <!-- Modal Konfirmasi Check-in -->
  <div x-show="showModal" 
       x-cloak
       class="fixed inset-0 z-50 overflow-y-auto" 
       style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
      <div x-show="showModal"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform scale-90"
           x-transition:enter-end="opacity-100 transform scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 transform scale-100"
           x-transition:leave-end="opacity-0 transform scale-90"
           class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative">
        
        <!-- Header Modal -->
        <div class="text-center mb-6">
          <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check-circle text-4xl text-blue-600"></i>
          </div>
          <h3 class="text-2xl font-bold text-slate-800 mb-2">Konfirmasi Check-in</h3>
          <p class="text-slate-500">Pastikan data sudah benar sebelum melanjutkan</p>
        </div>

        <!-- Detail Info -->
        <div class="bg-slate-50 rounded-xl p-6 mb-6 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <i class="fas fa-user text-blue-600"></i>
            </div>
            <div class="flex-1">
              <p class="text-xs text-slate-500">Nama Tamu</p>
              <p class="font-bold text-slate-800" x-text="formData.guestName"></p>
            </div>
          </div>
          
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <i class="fas fa-door-open text-teal-600"></i>
            </div>
            <div class="flex-1">
              <p class="text-xs text-slate-500">Kamar</p>
              <p class="font-bold text-slate-800">{{ $room->room_number }} - {{ $room->type }}</p>
            </div>
          </div>
          
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <i class="fas fa-calendar text-amber-600"></i>
            </div>
            <div class="flex-1">
              <p class="text-xs text-slate-500">Durasi Menginap</p>
              <p class="font-bold text-slate-800" x-text="formData.duration + ' Malam'"></p>
            </div>
          </div>
          
          <div class="flex items-center gap-3 pt-3 border-t border-slate-200">
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
              <i class="fas fa-money-bill-wave text-emerald-600"></i>
            </div>
            <div class="flex-1">
              <p class="text-xs text-slate-500">Total Pembayaran</p>
              <p class="font-bold text-emerald-600 text-xl" x-text="'Rp ' + formData.total"></p>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
          <button 
            type="button"
            @click="submitForm()"
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
            <i class="fas fa-check"></i>
            Ya, Proses Check-in
          </button>
          <button 
            type="button"
            @click="showModal = false"
            class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
            <i class="fas fa-times"></i>
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>
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
  
  // Refresh CSRF token every 10 minutes to prevent page expiration
  setInterval(function() {
    fetch('{{ route("dashboard") }}', {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(response => response.text()).then(html => {
      // Extract new CSRF token from response
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newToken = doc.querySelector('meta[name="csrf-token"]');
      if (newToken) {
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
          tokenInput.value = newToken.getAttribute('content');
        }
        // Update meta tag too
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken.getAttribute('content'));
      }
    }).catch(err => console.log('Token refresh failed:', err));
  }, 600000); // 10 minutes
  
  // Alpine.js component methods
  document.addEventListener('alpine:init', () => {
    Alpine.data('checkInForm', () => ({
      showModal: false,
      formData: {},
      
      showConfirmModal() {
        const guestName = document.querySelector('input[name="guest_name"]').value.trim();
        const guestNik = document.querySelector('input[name="guest_nik"]').value.trim();
        const guestPhone = document.querySelector('input[name="guest_phone"]').value.trim();
        const duration = document.getElementById('duration').value;
        
        if (!guestName || !guestNik || !guestPhone) {
          alert('⚠️ Mohon lengkapi data identitas tamu (Nama, NIK, dan No. HP) terlebih dahulu!');
          return;
        }
        
        // Set form data for modal display
        this.formData = {
          guestName: guestName,
          duration: duration,
          total: (pricePerNight * duration).toLocaleString('id-ID')
        };
        
        this.showModal = true;
      },
      
      submitForm() {
        // Get the form element
        const form = document.getElementById('checkInForm');
        
        // Submit the form
        form.submit();
      }
    }));
  });
  
  // Prevent form resubmission on page back
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
@endsection
