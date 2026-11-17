@extends('layouts.app')

@section('title', 'Edit Kamar - Hotel Nuansa')
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
    <h3 class="text-lg font-bold text-[#0B192C] mb-1">Edit Kamar {{ $room->room_number }}</h3>
    <p class="text-xs text-slate-400 mb-6">Ubah data tarif atau status operasional kamar</p>

    <form method="POST" action="{{ route('rooms.update', $room) }}" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- No. Kamar (Read only) -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Kamar</label>
        <input type="text" disabled value="{{ $room->room_number }}" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-stone-100 text-slate-500 font-bold">
      </div>

      <!-- Tipe Kamar (Read only) -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Kamar</label>
        <input type="text" disabled value="{{ $room->type }}" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-stone-100 text-slate-500 font-semibold">
      </div>

      <!-- Tarif per Malam -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tarif per Malam (Rp) <span class="text-rose-500">*</span></label>
        <input type="number" name="price_per_night" id="price_per_night" required min="0" 
               value="{{ old('price_per_night', $room->price_per_night) }}"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm font-bold text-[#0B192C] focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('price_per_night')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Status -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Kamar</label>
        <select name="status" 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available (Siap Ditempati)</option>
          <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Occupied (Sedang Dihuni)</option>
          <option value="dirty" {{ old('status', $room->status) === 'dirty' ? 'selected' : '' }}>Dirty (Butuh Pembersihan)</option>
          <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance (Perawatan)</option>
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
          Perbarui Kamar
        </button>
      </div>

    </form>
  </div>

</div>
@endsection
