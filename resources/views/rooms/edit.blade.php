@extends('layouts.app')

@section('content')
<div class="w-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Edit Kamar {{ $room->room_number }}</h1>
    <p class="text-gray-600 mt-1">Perbarui informasi kamar</p>
  </div>

  <!-- Form Card -->
  <div class="card p-8">
    <form method="POST" action="{{ route('rooms.update', $room) }}" class="space-y-6">
      @csrf @method('PUT')

      <!-- Harga -->
      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-4 top-2.5 text-gray-600 font-medium">Rp</span>
          <input type="number" name="price_per_night" step="1" value="{{ $room->price_per_night }}" required class="w-full px-4 py-2 pl-10 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('price_per_night') ? 'border-red-500' : '' }}">
        </div>
        @error('price_per_night')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-semibold text-gray-900 mb-2">Status Kamar</label>
        <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Tersedia</option>
          <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Terisi</option>
          <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
      </div>

      <!-- Buttons -->
      <div class="flex gap-4 pt-4">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-check"></i> Simpan Perubahan
        </button>
        <a href="{{ route('rooms.index') }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
