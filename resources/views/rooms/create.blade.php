@extends('layouts.app')

@section('title', 'Tambah Kamar Baru - Hotel Nuansa')
@section('page_title', 'Kamar')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Back button -->
  <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Daftar Kamar</span>
  </a>

  <!-- Form Card -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
    <h3 class="text-lg font-bold text-[#0B192C] mb-1">Tambah Kamar Baru</h3>
    <p class="text-xs text-slate-400 mb-6">Lengkapi data untuk menambahkan unit kamar hotel baru</p>

    <form method="POST" action="{{ route('rooms.store') }}" class="space-y-5">
      @csrf

      <!-- No. Kamar -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Kamar <span class="text-rose-500">*</span></label>
        <input type="text" name="room_number" required value="{{ old('room_number') }}" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 {{ $errors->has('room_number') ? 'border-rose-400' : '' }}" 
               placeholder="Contoh: 101, 201">
        @error('room_number')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Tipe Kamar -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Kamar <span class="text-rose-500">*</span></label>
        <select name="type" required 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="Standard (Kipas)" {{ old('type') === 'Standard (Kipas)' ? 'selected' : '' }}>Standard (Kipas)</option>
          <option value="Standard Plus (Kipas)" {{ old('type') === 'Standard Plus (Kipas)' ? 'selected' : '' }}>Standard Plus (Kipas)</option>
          <option value="Deluxe (AC)" {{ old('type') === 'Deluxe (AC)' ? 'selected' : '' }}>Deluxe (AC)</option>
          <option value="Suite (AC + TV)" {{ old('type') === 'Suite (AC + TV)' ? 'selected' : '' }}>Suite (AC + TV)</option>
        </select>
        @error('type')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Tarif per Malam -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tarif per Malam (Rp) <span class="text-rose-500">*</span></label>
        <input type="number" name="price_per_night" id="price_per_night" required min="0" value="{{ old('price_per_night') }}"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm font-bold text-[#0B192C] focus:outline-none focus:ring-2 focus:ring-amber-400"
               placeholder="120000">
        @error('price_per_night')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Status Awal -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Awal</label>
        <select name="status" 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available (Siap Ditempati)</option>
          <option value="dirty" {{ old('status') === 'dirty' ? 'selected' : '' }}>Dirty (Butuh Pembersihan)</option>
          <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance (Perawatan)</option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-3 pt-4 border-t border-stone-100">
        <a href="{{ route('rooms.index') }}" 
           class="px-6 py-2.5 rounded-full border border-stone-300 bg-white hover:bg-stone-50 text-slate-700 font-bold text-xs shadow-xs transition-all">
          Batal
        </a>
        <button type="submit" 
                class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-7 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
          Simpan Kamar
        </button>
      </div>

    </form>
  </div>

</div>
@endsection
