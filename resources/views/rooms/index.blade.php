@extends('layouts.app')

@section('title', 'Manajemen Kamar - Hotel Nuansa')
@section('page_title', 'Kamar')

@section('content')
<div class="space-y-6">

  <!-- TOP HEADER & ACTION -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Daftar Kamar</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">Kelola tipe, tarif, dan ketersediaan unit kamar hotel</p>
    </div>

    @if(auth()->user()->role === 'admin')
      <a href="{{ route('rooms.create') }}" 
         class="inline-flex items-center gap-2 bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition-all self-start sm:self-auto active:scale-95">
        <i class="fas fa-plus"></i>
        <span>Tambah Kamar</span>
      </a>
    @endif
  </div>

  <!-- STATUS SUMMARY CARDS -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Kamar -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Total Kamar</p>
        <h3 class="text-2xl font-black text-[#0B192C] mt-1">{{ $summary['total'] }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Kapasitas Hotel</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-stone-100 flex items-center justify-center text-slate-600">
        <i class="fas fa-door-open text-base"></i>
      </div>
    </div>

    <!-- Tersedia -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Tersedia</p>
        <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $summary['available'] }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Siap Ditempati</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
        <i class="fas fa-check-circle text-base"></i>
      </div>
    </div>

    <!-- Terisi -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Terisi</p>
        <h3 class="text-2xl font-black text-rose-600 mt-1">{{ $summary['occupied'] }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Sedang Dihuni</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600">
        <i class="fas fa-user-check text-base"></i>
      </div>
    </div>

    <!-- Perlu Cleaning -->
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Perlu Cleaning</p>
        <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $summary['maintenance'] }}</h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Kotor / Perawatan</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
        <i class="fas fa-broom text-base"></i>
      </div>
    </div>
  </div>

  <!-- ROOMS TABLE CARD -->
  <div class="bg-white rounded-3xl shadow-sm border border-stone-200/50 overflow-hidden">
    <div class="p-6 border-b border-stone-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-[#0B192C]">Katalog & Tarif Kamar</h3>
      <span class="text-xs font-semibold text-slate-400">{{ count($rooms) }} Unit Kamar</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs md:text-sm">
        <thead class="bg-[#F8F5EF] text-slate-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-6">Nomor</th>
            <th class="py-3.5 px-6">Tipe Kamar</th>
            <th class="py-3.5 px-6">Tarif / Malam</th>
            <th class="py-3.5 px-6 text-center">Status</th>
            <th class="py-3.5 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100 font-medium">
          @forelse($rooms as $room)
            <tr class="hover:bg-[#FBF9F5] transition-colors">
              <td class="py-4 px-6 font-black text-base text-[#0B192C]">
                {{ $room->room_number }}
              </td>
              <td class="py-4 px-6 text-slate-700 font-semibold">
                {{ $room->type }}
              </td>
              <td class="py-4 px-6 font-extrabold text-[#0B192C]">
                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
              </td>
              <td class="py-4 px-6 text-center">
                @if($room->status === 'available')
                  <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full inline-block">
                    Available
                  </span>
                @elseif($room->status === 'occupied')
                  <span class="bg-[#FEE2E2] text-[#DC2626] text-xs font-bold px-3 py-1 rounded-full inline-block">
                    Occupied
                  </span>
                @elseif($room->status === 'dirty')
                  <span class="bg-[#FEF3C7] text-[#D97706] text-xs font-bold px-3 py-1 rounded-full inline-block">
                    Dirty
                  </span>
                @else
                  <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-full inline-block">
                    Maintenance
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 text-right">
                <div class="inline-flex items-center gap-2 justify-end">
                  @if($room->status === 'dirty')
                    <form method="POST" action="{{ route('rooms.markClean', $room->id) }}" class="inline">
                      @csrf
                      <button type="submit" 
                              class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-full text-xs transition-all shadow-xs"
                              title="Tandai kamar selesai dibersihkan">
                        <i class="fas fa-broom mr-1"></i> Tandai Bersih
                      </button>
                    </form>
                  @endif

                  @if(auth()->user()->role === 'admin')
                    <a href="{{ route('rooms.edit', $room) }}" 
                       class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-700 flex items-center justify-center transition-all"
                       title="Edit Kamar">
                      <i class="fas fa-edit text-xs"></i>
                    </a>

                    <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="inline" onsubmit="return confirm('Hapus kamar nomor {{ $room->room_number }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="w-8 h-8 rounded-full bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-all"
                              title="Hapus Kamar">
                        <i class="fas fa-trash text-xs"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-slate-400 text-xs font-medium">
                Belum ada data kamar terdaftar.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
