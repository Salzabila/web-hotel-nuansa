@extends('layouts.app')

@section('content')
<div class="w-full">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Check-in Tamu Baru</h1>
    <p class="text-gray-500 mt-1 text-sm">
      <span class="inline-flex items-center gap-2">
        <i class="fas fa-door-open text-blue-500"></i>
        Kamar {{ $room->room_number }} - {{ $room->type }}
      </span>
    </p>
  </div>

  <div class="card p-6 rounded-xl shadow-md bg-white">
    <form method="POST" action="{{ route('transactions.store', $room->id) }}" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Tamu <span class="text-red-500">*</span></label>
        <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="w-full px-4 py-2 border-2 border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent {{ $errors->has('guest_name') ? 'border-red-500' : '' }}" placeholder="Masukkan nama lengkap" required>
        @error('guest_name')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>@enderror
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">NIK/Identitas <span class="text-red-500">*</span></label>
        <input type="text" name="guest_nik" value="{{ old('guest_nik') }}" class="w-full px-4 py-2 border-2 border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent {{ $errors->has('guest_nik') ? 'border-red-500' : '' }}" placeholder="Nomor Identitas (KTP/Paspor)" required>
        @error('guest_nik')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>@enderror
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat Lengkap</label>
        <textarea name="guest_address" class="w-full px-4 py-2 border-2 border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent" rows="3" placeholder="Masukkan alamat lengkap (opsional)">{{ old('guest_address') }}</textarea>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Durasi Menginap <span class="text-red-500">*</span></label>
        <div class="flex items-center gap-3">
          <input type="number" name="duration" id="duration" class="flex-1 px-4 py-2 border-2 border-slate-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent" min="1" value="{{ old('duration', 1) }}" required onchange="updateTotal()" oninput="updateTotal()">
          <span class="text-gray-700 font-semibold whitespace-nowrap">malam</span>
        </div>
        @error('duration')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>@enderror
      </div>

      <div class="flex items-center gap-3 bg-slate-50 px-4 py-3 rounded-lg border border-slate-200">
        <input type="checkbox" name="is_ktp_held" id="is_ktp_held" class="w-5 h-5 text-yellow-400 rounded cursor-pointer" {{ old('is_ktp_held') ? 'checked' : '' }}>
        <label for="is_ktp_held" class="text-sm text-gray-700 font-medium cursor-pointer flex-1">Tahan Kartu Identitas sebagai jaminan</label>
      </div>

      <!-- Price Summary Card -->
      <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl p-6 space-y-3">
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-700">Harga per Malam:</span>
          <span class="font-bold text-yellow-900">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-700">Durasi:</span>
          <span class="font-bold text-yellow-900"><span id="display-duration">1</span> malam</span>
        </div>
        <div class="border-t-2 border-yellow-200 pt-3 flex justify-between items-center">
          <span class="font-bold text-gray-900 text-lg">Total Harga:</span>
          <span class="font-bold text-2xl text-yellow-700 drop-shadow-sm" id="total">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex gap-3 pt-6">
        <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 rounded-lg transition-all shadow-md flex items-center justify-center gap-2">
          <i class="fas fa-check-circle text-lg"></i> Proses Check-in
        </button>
        <a href="{{ route('dashboard') }}" class="flex-1 bg-slate-300 hover:bg-slate-400 text-gray-900 font-bold py-3 rounded-lg transition-all shadow-md flex items-center justify-center gap-2">
          <i class="fas fa-times-circle text-lg"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  const pricePerNight = {{ $room->price_per_night }};
  function updateTotal() {
    const duration = parseInt(document.getElementById('duration').value) || 1;
    const total = pricePerNight * duration;
    document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('display-duration').textContent = duration;
  }
  updateTotal();
</script>
@endsection
