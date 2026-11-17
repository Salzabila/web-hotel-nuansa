@extends('layouts.app')

@section('title', 'Edit Pengguna - Hotel Nuansa')
@section('page_title', 'Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Back button -->
  <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Daftar Pengguna</span>
  </a>

  <!-- Form Card -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
    <h3 class="text-lg font-bold text-[#0B192C] mb-1">Edit Pengguna: {{ $user->name }}</h3>
    <p class="text-xs text-slate-400 mb-6">Perbarui nama, nomor identitas login, atau hak akses</p>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Nama Lengkap -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
        <input type="text" name="name" required value="{{ old('name', $user->name) }}" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 {{ $errors->has('name') ? 'border-rose-400' : '' }}">
        @error('name')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- No. HP / Username Login -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / Username Login <span class="text-rose-500">*</span></label>
        <input type="text" name="phone" required value="{{ old('phone', $user->phone) }}" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 {{ $errors->has('phone') ? 'border-rose-400' : '' }}">
        @error('phone')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Password (Optional on edit) -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
        <input type="password" name="password" 
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
               placeholder="Kosongkan jika tidak ingin mengubah password">
        @error('password')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Role -->
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Peran (Role) <span class="text-rose-500">*</span></label>
        <select name="role" required 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir (Operasional Front Office)</option>
          <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Akses Penuh Sistem)</option>
        </select>
        @error('role')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center gap-3 pt-4 border-t border-stone-100">
        <a href="{{ route('users.index') }}" 
           class="px-6 py-2.5 rounded-full border border-stone-300 bg-white hover:bg-stone-50 text-slate-700 font-bold text-xs shadow-xs transition-all">
          Batal
        </a>
        <button type="submit" 
                class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-7 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
          Perbarui Pengguna
        </button>
      </div>

    </form>
  </div>

</div>
@endsection
