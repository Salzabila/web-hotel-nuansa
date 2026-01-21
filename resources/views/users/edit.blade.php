@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-5">
    <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium mb-2 transition">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali</span>
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Edit User</h1>
    <p class="text-slate-500 mt-1 text-sm">Update informasi user</p>
  </div>

  <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 max-w-2xl">
    @csrf
    @method('PUT')
    
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
          Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <input 
          type="text" 
          name="name" 
          value="{{ old('name', $user->name) }}" 
          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
          required>
        @error('name')
          <span class="block mt-1 text-xs text-red-600">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
          </span>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
          Nomor Telepon <span class="text-red-500">*</span>
        </label>
        <input 
          type="tel" 
          name="phone" 
          value="{{ old('phone', $user->phone) }}" 
          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" 
          required>
        @error('phone')
          <span class="block mt-1 text-xs text-red-600">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
          </span>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
          Role <span class="text-red-500">*</span>
        </label>
        <select 
          name="role" 
          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror"
          required>
          <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
        </select>
        @error('role')
          <span class="block mt-1 text-xs text-red-600">
            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
          </span>
        @enderror
      </div>

      <!-- Info Alert -->
      <div class="bg-amber-50 border-l-4 border-amber-500 p-3 rounded-lg">
        <div class="flex items-start gap-2">
          <i class="fas fa-info-circle text-amber-600 text-sm mt-0.5"></i>
          <p class="text-xs text-amber-800">
            Untuk mengubah password, gunakan tombol <span class="font-semibold">Reset Password</span> di halaman daftar user.
          </p>
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="flex gap-3 mt-5">
      <a href="{{ route('users.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
        <i class="fas fa-times"></i>
        <span>Batal</span>
      </a>
      <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
        <i class="fas fa-save"></i>
        <span>Update User</span>
      </button>
    </div>
  </form>
</div>
@endsection
