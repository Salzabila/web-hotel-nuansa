@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Kelola Kasir</h1>
    <p class="text-slate-500 mt-2 text-base">Manajemen data kasir untuk sistem checkout</p>
  </div>

  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-check-circle text-xl"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-exclamation-circle text-xl"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- Add New Cashier Form -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-6">
    <div class="flex items-center gap-3 mb-4">
      <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
        <i class="fas fa-user-plus text-blue-600 text-lg"></i>
      </div>
      <div>
        <h2 class="text-lg font-bold text-slate-800">Tambah Kasir Baru</h2>
        <p class="text-xs text-slate-500">Input nama kasir yang bertugas</p>
      </div>
    </div>

    <form method="POST" action="{{ route('cashiers.store') }}" class="flex gap-3">
      @csrf
      <div class="flex-1">
        <input 
          type="text" 
          name="name" 
          placeholder="Masukkan nama kasir (contoh: Budi Santoso)"
          class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          maxlength="100"
          required>
        @error('name')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <button 
        type="submit" 
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-md flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah
      </button>
    </form>
  </div>

  <!-- Cashier List -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Kasir</h2>
        <p class="text-slate-500 text-sm mt-1">Total: {{ $cashiers->count() }} kasir aktif</p>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <th class="text-left py-4 px-6 font-bold text-gray-900">No</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Nama Kasir</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Ditambahkan</th>
            <th class="text-center py-4 px-6 font-bold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($cashiers as $index => $cashier)
            <tr class="hover:bg-blue-50 transition-colors duration-150">
              <td class="py-4 px-6 font-semibold text-gray-900">{{ $index + 1 }}</td>
              <td class="py-4 px-6 font-semibold text-gray-900">{{ $cashier->name }}</td>
              <td class="py-4 px-6 text-gray-700">{{ $cashier->created_at->format('d M Y') }}</td>
              <td class="py-4 px-6">
                <div class="flex items-center justify-center">
                  <form action="{{ route('cashiers.destroy', $cashier) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kasir {{ $cashier->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-3 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="line-height: 1; width: 75px; justify-content: center;">
                      <i class="fas fa-trash" style="font-size: 11px; vertical-align: middle;"></i>
                      <span style="vertical-align: middle;">Hapus</span>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-16 text-center text-slate-500">
                <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
                <p class="text-lg font-medium">Belum ada data kasir</p>
                <p class="text-sm text-slate-400 mt-1">Silakan tambahkan kasir baru untuk memulai</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
