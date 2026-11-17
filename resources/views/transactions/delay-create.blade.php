@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-lg mb-3 transition border-2 border-slate-300">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Beranda</span>
    </a>
    <div class="flex items-center justify-between gap-4 flex-wrap">
      <div>
        <h1 class="text-3xl font-bold text-slate-800">Check-in Delay (Lengkap)</h1>
        <p class="text-slate-500 mt-2 text-base flex items-center gap-2">
          <i class="fas fa-book-open text-amber-600"></i>
          Kamar {{ $room->room_number }} - {{ $room->type }}
        </p>
      </div>
      <a href="{{ route('transactions.create', $room->id) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md">
        <i class="fas fa-bolt"></i>
        <span>Ke Express Check-in</span>
      </a>
    </div>
  </div>

  <form method="POST" action="{{ route('transactions.delayStore', $room->id) }}" id="delayCheckInForm">
    @csrf

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-user-check text-amber-600 text-lg"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-800">Data Tamu</h2>
            <p class="text-xs text-slate-500">Isi buku tamu lengkap sebelum check-in</p>
          </div>
        </div>

        <div class="space-y-5">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Tamu <span class="text-red-500">*</span></label>
            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Nama lengkap tamu" required>
            @error('guest_name')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK / KTP <span class="text-red-500">*</span></label>
            <input type="text" name="guest_nik" value="{{ old('guest_nik') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="16 digit NIK" maxlength="16" required>
            @error('guest_nik')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP <span class="text-red-500">*</span></label>
            <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="08xxxxxxxxxx" required>
            @error('guest_phone')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="guest_address" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Alamat lengkap tamu" required>{{ old('guest_address') }}</textarea>
            @error('guest_address')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-bed text-blue-600 text-lg"></i>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-800">Detail Kamar & Pembayaran</h2>
            <p class="text-xs text-slate-500">Konfirmasi masa tinggal dan metode pembayaran</p>
          </div>
        </div>

        <div class="space-y-5">
          <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200">
            <div class="flex items-center justify-between mb-2">
              <span class="text-sm font-semibold text-slate-700">Nomor Kamar</span>
              <span class="text-2xl font-bold text-blue-700">{{ $room->room_number }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-semibold text-slate-700">Tipe</span>
              <span class="text-lg font-bold text-blue-900">{{ $room->type }}</span>
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Lama Menginap <span class="text-red-500">*</span></label>
            <select name="duration" id="duration" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-lg font-semibold text-slate-800" required onchange="updateTotal()">
              @for($i = 1; $i <= 30; $i++)
                <option value="{{ $i }}" {{ old('duration', 1) == $i ? 'selected' : '' }}>{{ $i }} Malam</option>
              @endfor
            </select>
            @error('duration')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>

          <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-5 rounded-xl border-2 border-emerald-200 space-y-3">
            <div class="flex justify-between items-center text-sm">
              <span class="text-slate-700 font-medium">Harga per Malam</span>
              <span class="font-bold text-emerald-900">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span class="text-slate-700 font-medium">Durasi</span>
              <span class="font-bold text-emerald-900"><span id="display-duration">1</span> Malam</span>
            </div>
            <div class="border-t-2 border-emerald-300 pt-3 flex justify-between items-center">
              <span class="font-bold text-slate-900 text-base">Total Biaya</span>
              <span class="font-bold text-2xl text-emerald-700" id="total">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
            </div>
          </div>

          <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-shield-alt text-amber-600"></i>
              <span class="font-bold text-slate-800">Jaminan Identitas</span>
            </div>
            <select name="guarantee_type" class="w-full px-4 py-3 border border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-slate-800 font-semibold bg-white" required>
              <option value="">-- Pilih Jenis Jaminan --</option>
              <option value="KTP" {{ old('guarantee_type') == 'KTP' ? 'selected' : '' }}>KTP</option>
              <option value="SIM" {{ old('guarantee_type') == 'SIM' ? 'selected' : '' }}>SIM</option>
              <option value="STNK" {{ old('guarantee_type') == 'STNK' ? 'selected' : '' }}>STNK</option>
            </select>
            @error('guarantee_type')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror

            <div class="mt-4 flex items-start gap-3 bg-white p-3 rounded-lg border border-amber-300">
              <input type="checkbox" name="is_ktp_held" id="is_ktp_held" class="w-5 h-5 text-amber-600 rounded cursor-pointer mt-0.5" {{ old('is_ktp_held') ? 'checked' : '' }}>
              <label for="is_ktp_held" class="text-sm font-medium text-slate-800 cursor-pointer flex-1">
                Tahan jaminan asli selama menginap
              </label>
            </div>
          </div>

          <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-handshake text-purple-600"></i>
              <span class="font-bold text-slate-800">Komisi Makelar (TC)</span>
            </div>
            <div class="flex items-start gap-3 bg-white p-3 rounded-lg border border-purple-300 mb-3">
              <input type="checkbox" name="is_tc" id="is_tc" class="w-5 h-5 text-purple-600 rounded cursor-pointer mt-0.5" {{ old('is_tc') ? 'checked' : '' }} onchange="toggleTCNominal()">
              <label for="is_tc" class="text-sm font-medium text-slate-800 cursor-pointer flex-1">Tamu via Makelar/Agen</label>
            </div>

            <div id="tc_nominal_wrapper" class="hidden overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0; opacity: 0;">
              <label class="block text-sm font-medium text-slate-700 mb-2">Nominal Komisi (Rp) <span class="text-red-500">*</span></label>
              <div class="flex items-stretch rounded-xl overflow-hidden border border-purple-300 focus-within:ring-2 focus-within:ring-purple-500 focus-within:border-purple-500 transition-all">
                <div class="flex items-center justify-center bg-slate-100 px-4 border-r border-purple-200">
                  <span class="text-slate-600 font-semibold text-base select-none">Rp</span>
                </div>
                <input type="text" id="tc_nominal_display" class="flex-1 px-4 py-3 border-0 focus:outline-none focus:ring-0 text-slate-800 font-semibold bg-white" placeholder="Masukkan nominal komisi" oninput="formatRupiah(this)">
                <input type="hidden" name="tc_nominal" id="tc_nominal" value="{{ old('tc_nominal', 0) }}">
              </div>
            </div>
          </div>

          <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-credit-card text-blue-600"></i>
              <span class="font-bold text-slate-800">Metode Pembayaran</span>
            </div>
            <select name="payment_method_id" id="payment_method_id" class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 font-semibold bg-white" required>
              <option value="">-- Pilih Metode Pembayaran --</option>
              @foreach($paymentMethods as $method)
                <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>{{ $method->bank_name }} @if($method->account_number) - {{ $method->account_number }} @endif</option>
              @endforeach
            </select>
            @error('payment_method_id')
              <span class="block mt-1.5 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-book-open text-xl"></i>
        <span class="text-lg">Check-in Delay / Buku Tamu</span>
      </button>
      <a href="{{ route('transactions.create', $room->id) }}" class="px-8 bg-slate-600 hover:bg-slate-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
        <i class="fas fa-bolt"></i>
        <span class="text-lg">Express</span>
      </a>
    </div>
  </form>
</div>

<script>
  const pricePerNight = {{ $room->price_per_night }};

  function updateTotal() {
    const duration = parseInt(document.getElementById('duration').value) || 1;
    const total = pricePerNight * duration;
    document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('display-duration').textContent = duration;
  }

  function toggleTCNominal() {
    const isChecked = document.getElementById('is_tc').checked;
    const wrapper = document.getElementById('tc_nominal_wrapper');
    const inputDisplay = document.getElementById('tc_nominal_display');
    const inputHidden = document.getElementById('tc_nominal');

    if (isChecked) {
      wrapper.classList.remove('hidden');
      wrapper.offsetHeight;
      wrapper.style.maxHeight = '200px';
      wrapper.style.opacity = '1';
      inputDisplay.required = true;
      setTimeout(() => inputDisplay.focus(), 300);
    } else {
      wrapper.style.maxHeight = '0';
      wrapper.style.opacity = '0';
      inputDisplay.required = false;
      inputDisplay.value = '';
      inputHidden.value = 0;
      setTimeout(() => wrapper.classList.add('hidden'), 300);
    }
  }

  function formatRupiah(input) {
    let value = input.value.replace(/\D/g, '');
    let formatted = '';
    if (value) {
      let reversed = value.split('').reverse().join('');
      for (let i = 0; i < reversed.length; i++) {
        if (i > 0 && i % 3 === 0) {
          formatted = '.' + formatted;
        }
        formatted = reversed[i] + formatted;
      }
    }
    input.value = formatted;
    document.getElementById('tc_nominal').value = value || 0;
  }

  updateTotal();
  toggleTCNominal();
</script>
@endsection
