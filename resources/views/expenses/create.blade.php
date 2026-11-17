@extends('layouts.app')

@section('title', 'Catat Pengeluaran - Hotel Nuansa')
@section('page_title', 'Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Back button -->
  <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Riwayat Pengeluaran</span>
  </a>

  <!-- Form Card -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
    <h3 class="text-lg font-bold text-[#0B192C] mb-1">Catat Biaya Operasional</h3>
    <p class="text-xs text-slate-400 mb-6">Input rincian pengeluaran hotel untuk pencatatan laba bersih otomatis</p>

    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-5">
      @csrf

      <!-- Kategori -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Pengeluaran <span class="text-rose-500">*</span></label>
        <select name="category" required 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="utilities" {{ old('category') === 'utilities' ? 'selected' : '' }}>Utilities (Listrik, Air, Wifi, Telepon)</option>
          <option value="maintenance" {{ old('category') === 'maintenance' ? 'selected' : '' }}>Maintenance (Perbaikan AC, Plumbing, Cat, Tukang)</option>
          <option value="supplies" {{ old('category') === 'supplies' ? 'selected' : '' }}>Supplies (Sabun, Sampo, Linen, Air Mineral, Kebersihan)</option>
          <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other (Keperluan Lainnya)</option>
        </select>
        @error('category')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan / Deskripsi</label>
        <input type="text" name="description" value="{{ old('description') }}" 
               placeholder="Contoh: Beli token listrik kamar 101-108, service AC 2 unit..."
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('description')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Nominal -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal Pengeluaran (Rp) <span class="text-rose-500">*</span></label>
        <input type="number" name="amount" required min="0" value="{{ old('amount') }}"
               placeholder="Contoh: 350000"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm font-bold text-[#0B192C] focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('amount')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Tanggal Pengeluaran -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Biaya <span class="text-rose-500">*</span></label>
        <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
        @error('date')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-3 pt-4 border-t border-stone-100">
        <a href="{{ route('expenses.index') }}" 
           class="px-6 py-2.5 rounded-full border border-stone-300 bg-white hover:bg-stone-50 text-slate-700 font-bold text-xs shadow-xs transition-all">
          Batal
        </a>
        <button type="submit" 
                class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-7 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
          Simpan Biaya
        </button>
      </div>

    </form>
  </div>

</div>
@endsection
