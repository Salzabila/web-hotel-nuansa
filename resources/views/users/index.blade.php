@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Hotel Nuansa')
@section('page_title', 'Pengguna')

@section('content')
<div class="space-y-6">

  <!-- TOP HEADER & ACTION -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Manajemen Pengguna</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">Kelola akun staf, petugas kasir, dan administrator hotel</p>
    </div>

    <a href="{{ route('users.create') }}" 
       class="inline-flex items-center gap-2 bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition-all self-start sm:self-auto active:scale-95">
      <i class="fas fa-plus"></i>
      <span>Tambah Pengguna</span>
    </a>
  </div>

  <!-- SUMMARY CARDS -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Total Akun</p>
        <h3 class="text-2xl font-black text-[#0B192C] mt-1">{{ $users->count() }} User</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Pengguna terdaftar</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-stone-100 flex items-center justify-center text-slate-600">
        <i class="fas fa-users text-base"></i>
      </div>
    </div>

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Administrator</p>
        <h3 class="text-2xl font-black text-[#1D58B8] mt-1">{{ $adminCount }} Akun</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Hak akses penuh</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-[#1D58B8]">
        <i class="fas fa-crown text-base"></i>
      </div>
    </div>

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Petugas Kasir</p>
        <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $users->where('role', 'kasir')->count() }} Akun</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Operasional front desk</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
        <i class="fas fa-user-shield text-base"></i>
      </div>
    </div>
  </div>

  <!-- USERS TABLE CARD -->
  <div class="bg-white rounded-3xl shadow-sm border border-stone-200/50 overflow-hidden">
    <div class="p-6 border-b border-stone-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-[#0B192C]">Daftar Akun Pengguna</h3>
      <span class="text-xs font-semibold text-slate-400">{{ $users->count() }} Pengguna</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs md:text-sm">
        <thead class="bg-[#F8F5EF] text-slate-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-6">Nama Pengguna</th>
            <th class="py-3.5 px-6">No. HP / Username</th>
            <th class="py-3.5 px-6 text-center">Peran (Role)</th>
            <th class="py-3.5 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100 font-medium">
          @forelse($users as $user)
            <tr class="hover:bg-[#FBF9F5] transition-colors">
              <td class="py-4 px-6">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-[#0B192C] text-white font-black text-xs flex items-center justify-center shadow-xs">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                  <div>
                    <p class="font-bold text-[#0B192C]">{{ $user->name }}</p>
                    <p class="text-[11px] text-slate-400">ID: #{{ $user->id }}</p>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 font-semibold text-slate-700">
                {{ $user->phone }}
              </td>
              <td class="py-4 px-6 text-center">
                @if($user->role === 'admin')
                  <span class="bg-[#0B192C] text-white text-xs font-bold px-3 py-1 rounded-full inline-block shadow-xs">
                    Admin
                  </span>
                @else
                  <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full inline-block">
                    Kasir
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 text-right">
                <div class="inline-flex items-center gap-2 justify-end">
                  <a href="{{ route('users.edit', $user) }}" 
                     class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-700 flex items-center justify-center transition-all"
                     title="Edit Data">
                    <i class="fas fa-edit text-xs"></i>
                  </a>

                  <!-- Reset Password -->
                  <form method="POST" action="{{ route('users.resetPassword', $user) }}" class="inline" onsubmit="return confirm('Reset password pengguna ini ke default?')">
                    @csrf
                    <button type="submit" 
                            class="w-8 h-8 rounded-full bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition-all"
                            title="Reset Password">
                      <i class="fas fa-key text-xs"></i>
                    </button>
                  </form>

                  @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="w-8 h-8 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-all"
                              title="Hapus Akun">
                        <i class="fas fa-trash text-xs"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-12 text-center text-slate-400 text-xs font-medium">
                Belum ada data pengguna.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
