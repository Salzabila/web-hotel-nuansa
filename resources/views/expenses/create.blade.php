@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-5">
    <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-2 transition">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali</span>
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Input Pengeluaran</h1>
    <p class="text-slate-500 mt-1 text-sm">Tambahkan biaya operasional baru</p>
  </div>

  <!-- Form Card -->
  <div class="bg-white overflow-hidden rounded-xl shadow-sm border border-slate-100 p-6">
    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-4">
      @csrf

      <!-- Kategori -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
        <select name="category" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('category') ? 'border-red-500' : '' }}">
          <option value="">-- Pilih Kategori --</option>
          <option value="maintenance" {{ old('category') === 'maintenance' ? 'selected' : '' }}>Pemeliharaan</option>
          <option value="utilities" {{ old('category') === 'utilities' ? 'selected' : '' }}>Utilitas (Listrik, Air, WiFi)</option>
          <option value="supplies" {{ old('category') === 'supplies' ? 'selected' : '' }}>Perlengkapan</option>
          <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('category')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('description') ? 'border-red-500' : '' }}" placeholder="Contoh: Perbaikan atap kamar 101">{{ old('description') }}</textarea>
        @error('description')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Jumlah -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah (Rp) <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-3 top-2 text-slate-600 font-medium text-sm pointer-events-none">Rp</span>
          <input 
            type="text" 
            id="amount_display" 
            class="w-full px-3 py-2 pl-9 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('amount') ? 'border-red-500' : '' }}" 
            placeholder="50.000"
            value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
            oninput="formatRupiahInput(this, 'amount')">
          <input type="hidden" name="amount" id="amount" value="{{ old('amount', '') }}" required>
        </div>
        @error('amount')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
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

      <!-- Tanggal -->
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('date') ? 'border-red-500' : '' }}">
        @error('date')<span class="block mt-1 text-xs text-red-600"><i class="fas fa-times-circle"></i> {{ $message }}</span>@enderror
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-3">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
          <i class="fas fa-check"></i> Simpan Pengeluaran
        </button>
        <a href="{{ route('expenses.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
          <i class="fas fa-times"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
