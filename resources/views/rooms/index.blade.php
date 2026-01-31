@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Manajemen Kamar</h1>
    <p class="text-slate-500 mt-2 text-base">Kelola dan pantau status kamar hotel</p>
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

  <!-- SECTION 1: CARD STATUS SUMMARY -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Kamar -->
    <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
      <div class="flex items-center justify-between gap-2">
        <div class="flex-1">
          <p class="text-slate-500 text-xs font-medium">Total Kamar</p>
          <p class="text-2xl font-bold text-slate-800 my-1">{{ $summary['total'] }}</p>
          <p class="text-xs text-slate-400">Kapasitas Hotel</p>
        </div>
        <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fas fa-door-open text-lg text-teal-500"></i>
        </div>
      </div>
    </div>

    <!-- Kamar Tersedia -->
    <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
      <div class="flex items-center justify-between gap-2">
        <div class="flex-1">
          <p class="text-slate-500 text-xs font-medium">Kamar Tersedia</p>
          <p class="text-2xl font-bold text-slate-800 my-1">{{ $summary['available'] }}</p>
          <p class="text-xs text-slate-400">Siap Ditempati</p>
        </div>
        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fas fa-check-circle text-lg text-emerald-500"></i>
        </div>
      </div>
    </div>

    <!-- Kamar Terisi -->
    <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
      <div class="flex items-center justify-between gap-2">
        <div class="flex-1">
          <p class="text-slate-500 text-xs font-medium">Kamar Terisi</p>
          <p class="text-2xl font-bold text-slate-800 my-1">{{ $summary['occupied'] }}</p>
          <p class="text-xs text-slate-400">Sedang Dihuni</p>
        </div>
        <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fas fa-user text-lg text-rose-500"></i>
        </div>
      </div>
    </div>

    <!-- Perlu Cleaning -->
    <div class="bg-white hover:shadow-lg transition-all duration-300 p-5 rounded-xl shadow-sm border border-slate-200 hover:border-slate-300">
      <div class="flex items-center justify-between gap-2">
        <div class="flex-1">
          <p class="text-slate-500 text-xs font-medium">Perlu Cleaning</p>
          <p class="text-2xl font-bold text-slate-800 my-1">{{ $summary['maintenance'] }}</p>
          <p class="text-xs text-slate-400">Butuh Pembersihan</p>
        </div>
        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fas fa-broom text-lg text-amber-600"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- SECTION 2: GRID VIEW (Quick Access) -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="mb-6">
      <h2 class="text-xl font-bold text-slate-800">Tampilan Grid Kamar</h2>
      <p class="text-slate-500 text-sm mt-1">Quick access untuk check-in dan monitoring status</p>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap gap-6 mb-6 text-sm bg-slate-50 p-5 rounded-xl">
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-green-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Tersedia</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-red-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Terisi</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-slate-400 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Kotor/Cleaning</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-yellow-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Pemeliharaan</span>
      </div>
    </div>

    <!-- Room Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
      @foreach($rooms as $room)
        @php
          $statusColor = match($room->status) {
            'available' => 'bg-gradient-to-br from-green-400 to-green-600 hover:from-green-500 hover:to-green-700',
            'occupied' => 'bg-gradient-to-br from-red-400 to-red-600 hover:from-red-500 hover:to-red-700',
            'dirty' => 'bg-gradient-to-br from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600',
            'maintenance' => 'bg-gradient-to-br from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700',
            default => 'bg-gradient-to-br from-gray-400 to-gray-600'
          };
          $statusText = match($room->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'dirty' => 'Kotor/Cleaning',
            'maintenance' => 'Pemeliharaan',
            default => 'Unknown'
          };
        @endphp
        @if($room->status === 'available')
          <a href="{{ route('transactions.create', $room->id) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</div>
          </a>
        @elseif($room->status === 'occupied')
          @php
            $activeTransaction = \App\Models\Transaction::where('room_id', $room->id)->where('status', 'active')->first();
          @endphp
          @if($activeTransaction)
            <a href="{{ route('transactions.checkout', $activeTransaction->id) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
              <div class="text-3xl mb-3 font-bold"><i class="fas fa-user"></i></div>
              <div class="font-bold text-base">{{ $room->room_number }}</div>
              <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
              <div class="text-xs opacity-80 mt-2 font-semibold">{{ $activeTransaction->guest_name }}</div>
              <div class="text-xs opacity-70 mt-1">Klik untuk Checkout</div>
            </a>
          @else
            <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg opacity-75">
              <div class="text-3xl mb-3 font-bold"><i class="fas fa-user"></i></div>
              <div class="font-bold text-base">{{ $room->room_number }}</div>
              <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
              <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
            </div>
          @endif
        @elseif($room->status === 'dirty')
          <form method="POST" action="{{ route('rooms.markClean', $room->id) }}" class="w-full confirm-form" data-confirm-title="Konfirmasi Cleaning" data-confirm-message="Apakah kamar {{ $room->room_number }} sudah bersih dan siap ditempati?">
            @csrf
            <button type="submit" class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition w-full cursor-pointer">
              <div class="text-3xl mb-3 font-bold"><i class="fas fa-broom"></i></div>
              <div class="font-bold text-base">{{ $room->room_number }}</div>
              <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
              <div class="text-xs opacity-80 mt-2 font-semibold">Perlu Cleaning</div>
              <div class="text-xs opacity-70 mt-1">Klik untuk Mark Clean</div>
            </button>
          </form>
        @else
          <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg opacity-75 cursor-not-allowed">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-wrench"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
          </div>
        @endif
      @endforeach
    </div>
  </div>

  <!-- SECTION 3: TABEL CRUD (Admin Management) -->
  @if(auth()->user()->role === 'admin')
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Management Kamar (Admin)</h2>
        <p class="text-slate-500 text-sm mt-1">CRUD Operations - Edit, Hapus, Tambah Kamar</p>
      </div>
      <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg">
        <i class="fas fa-plus"></i> Tambah Kamar
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <th class="text-left py-4 px-6 font-bold text-gray-900">No. Kamar</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Tipe</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Harga/Malam</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Status</th>
            <th class="text-center py-4 px-6 font-bold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($rooms as $room)
            <tr class="hover:bg-blue-50 transition-colors duration-150">
              <td class="py-4 px-6 font-semibold text-gray-900">{{ $room->room_number }}</td>
              <td class="py-4 px-6 text-gray-700">{{ $room->type }}</td>
              <td class="py-4 px-6 text-gray-900 font-medium">Rp {{ number_format($room->price_per_night,0,',','.') }}</td>
              <td class="py-4 px-6">
                @if($room->status === 'available')
                  <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-check-circle"></i> Tersedia
                  </span>
                @elseif($room->status === 'occupied')
                  <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-user"></i> Terisi
                  </span>
                @elseif($room->status === 'dirty')
                  <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-broom"></i> Kotor
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-wrench"></i> Maintenance
                  </span>
                @endif
              </td>
              <td class="py-4 px-6">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold text-xs px-3 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="line-height: 1; width: 75px; justify-content: center;">
                    <i class="fas fa-edit" style="font-size: 11px; vertical-align: middle;"></i>
                    <span style="vertical-align: middle;">Edit</span>
                  </a>

                  <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="inline-block confirm-form" data-confirm-title="Konfirmasi Hapus Kamar" data-confirm-message="Yakin ingin menghapus kamar {{ $room->room_number }}? Data tidak dapat dikembalikan.">
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
              <td colspan="5" class="py-16 text-center text-slate-500">
                <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
                <p class="text-lg font-medium">Tidak ada kamar</p>
                <p class="text-sm text-slate-400 mt-1">Silakan tambahkan kamar baru untuk memulai</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection
