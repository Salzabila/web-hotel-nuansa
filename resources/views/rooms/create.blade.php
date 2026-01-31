@extends('layouts.app')

@section('content')
<div class="w-full">
  <!-- Header -->
  <div class="mb-5">
    <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-2 transition">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali</span>
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Tambah Kamar Baru</h1>
    <p class="text-slate-500 mt-1 text-sm">Isi formulir di bawah untuk menambahkan kamar</p>
  </div>

  <!-- Form Card -->
  <div class="card p-6 rounded-xl shadow-sm bg-white">
    <form method="POST" action="{{ route('rooms.store') }}" class="space-y-4 confirm-form" data-confirm-title="Konfirmasi Tambah Kamar" data-confirm-message="Apakah data kamar baru sudah benar? Lanjutkan menyimpan?">
      @csrf

      <!-- No. Kamar -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">No. Kamar <span class="text-red-500">*</span></label>
        <input type="text" name="room_number" required value="{{ old('room_number') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('room_number') ? 'border-red-500' : '' }}" placeholder="Contoh: 101, 201, A1">
        @error('room_number')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Tipe Kamar -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tipe Kamar <span class="text-red-500">*</span></label>
        <select name="type" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('type') ? 'border-red-500' : '' }}">
          <option value="">-- Pilih Tipe Kamar --</option>
          <option value="Standard (Kipas)" {{ old('type') === 'Standard (Kipas)' ? 'selected' : '' }}>Standard - Kipas</option>
          <option value="Deluxe (AC)" {{ old('type') === 'Deluxe (AC)' ? 'selected' : '' }}>Deluxe - AC</option>
        </select>
        @error('type')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Harga -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-3 top-2 text-gray-600 font-medium text-sm pointer-events-none">Rp</span>
          <input 
            type="text" 
            id="price_display" 
            class="w-full px-3 py-2 pl-9 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('price_per_night') ? 'border-red-500' : '' }}" 
            placeholder="100.000"
            value="{{ old('price_per_night') ? number_format(old('price_per_night'), 0, ',', '.') : '' }}"
            oninput="formatRupiahInput(this, 'price_per_night')">
          <input type="hidden" name="price_per_night" id="price_per_night" value="{{ old('price_per_night', '') }}" required>
        </div>
        @error('price_per_night')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <script>
        function formatRupiahInput(input, hiddenId) {
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
          document.getElementById(hiddenId).value = value || '';
        }
      </script>

      <!-- Buttons -->
      <div class="flex gap-3 pt-3">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
          <i class="fas fa-check"></i> Simpan Kamar
        </button>
        <a href="{{ route('rooms.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
