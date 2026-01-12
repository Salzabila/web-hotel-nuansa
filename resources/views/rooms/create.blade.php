@extends('layouts.app')

@section('content')
<div class="w-full">
  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Kamar Baru</h1>
    <p class="text-gray-500 mt-1 text-sm">Isi formulir di bawah untuk menambahkan kamar</p>
  </div>

  <!-- Form Card -->
  <div class="card p-6 rounded-xl shadow-md bg-white">
    <form method="POST" action="{{ route('rooms.store') }}" class="space-y-6">
      @csrf

      <!-- No. Kamar -->
      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">No. Kamar <span class="text-red-500">*</span></label>
        <input type="text" name="room_number" required value="{{ old('room_number') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('room_number') ? 'border-red-500' : '' }}" placeholder="Contoh: 101, 201, A1">
        @error('room_number')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Tipe Kamar -->
      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Kamar <span class="text-red-500">*</span></label>
        <select name="type" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('type') ? 'border-red-500' : '' }}">
          <option value="">-- Pilih Tipe Kamar --</option>
          <option value="Standard (Kipas)" {{ old('type') === 'Standard (Kipas)' ? 'selected' : '' }}>Standard - Kipas</option>
          <option value="Deluxe (AC)" {{ old('type') === 'Deluxe (AC)' ? 'selected' : '' }}>Deluxe - AC</option>
        </select>
        @error('type')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Harga -->
      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-4 top-2.5 text-gray-600 font-medium">Rp</span>
          <input type="number" name="price_per_night" step="1" required value="{{ old('price_per_night') }}" class="w-full px-4 py-2 pl-10 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('price_per_night') ? 'border-red-500' : '' }}" placeholder="100000">
        </div>
        @error('price_per_night')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-4">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-check"></i> Simpan Kamar
        </button>
        <a href="{{ route('rooms.index') }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
