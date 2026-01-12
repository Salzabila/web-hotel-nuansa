@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Input Pengeluaran</h1>
    <p class="text-slate-500 mt-2 text-base">Tambahkan biaya operasional baru</p>
  </div>

  <!-- Form Card -->
  <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100 p-8">
    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6">
      @csrf

      <!-- Kategori -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
        <select name="category" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('category') ? 'border-red-500' : '' }}">
          <option value="">-- Pilih Kategori --</option>
          <option value="maintenance" {{ old('category') === 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
          <option value="utilities" {{ old('category') === 'utilities' ? 'selected' : '' }}>Utilitas (Listrik, Air, WiFi)</option>
          <option value="supplies" {{ old('category') === 'supplies' ? 'selected' : '' }}>Perlengkapan</option>
          <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('category')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('description') ? 'border-red-500' : '' }}" placeholder="Contoh: Perbaikan atap kamar 101">{{ old('description') }}</textarea>
        @error('description')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Jumlah -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-4 top-3 text-slate-600 font-medium">Rp</span>
          <input type="number" name="amount" step="1" value="{{ old('amount') }}" required class="w-full px-4 py-3 pl-10 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('amount') ? 'border-red-500' : '' }}" placeholder="50000">
        </div>
        @error('amount')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Tanggal -->
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('date') ? 'border-red-500' : '' }}">
        @error('date')<span class="block mt-1 text-sm text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Buttons -->
      <div class="flex gap-4 pt-4">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-check"></i> Simpan Pengeluaran
        </button>
        <a href="{{ route('expenses.index') }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
