@extends('layouts.app')

@section('content')
<div class="h-full">
<!-- Header -->
<div class="flex justify-between items-center mb-8">
  <div>
    <h1 class="text-3xl font-bold text-slate-800">Manajemen Kamar</h1>
    <p class="text-slate-500 mt-2 text-base">Kelola daftar kamar hotel</p>
  </div>
  <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-xl">
    <i class="fas fa-plus"></i> Tambah Kamar
  </a>
</div>

<!-- Table Card -->
<div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100">
  <table class="w-full">
    <thead>
      <tr class="border-b border-slate-200">
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">No. Kamar</th>
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Tipe</th>
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Harga/Malam</th>
        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Status</th>
        <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider bg-transparent">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rooms as $room)
        <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors duration-150 cursor-pointer room-row" data-url="{{ route('rooms.edit', $room) }}">
          <td class="px-6 py-4 font-semibold text-slate-800">{{ $room->room_number }}</td>
          <td class="px-6 py-4 text-slate-600">{{ $room->type }}</td>
          <td class="px-6 py-4 text-slate-800 font-medium">Rp {{ number_format($room->price_per_night,0,',','.') }}</td>
          <td class="px-6 py-4">
            @if($room->status === 'available')
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                <i class="fas fa-check-circle mr-1.5"></i>Tersedia
              </span>
            @elseif($room->status === 'occupied')
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600 border border-rose-100">
                <i class="fas fa-user mr-1.5"></i>Terisi
              </span>
            @else
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">
                <i class="fas fa-wrench mr-1.5"></i>Maintenance
              </span>
            @endif
          </td>
          <td class="px-6 py-4 text-center space-x-2 action-buttons">
            <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors border border-blue-200">
              <i class="fas fa-pencil text-sm"></i>
            </a>
            <form method="POST" action="{{ route('rooms.destroy', $room) }}" style="display:inline;">@csrf @method('DELETE')
              <button type="submit" class="inline-flex items-center justify-center w-9 h-9 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors border border-rose-200" onclick="return confirm('Yakin ingin menghapus kamar ini?')">
                <i class="fas fa-trash text-sm"></i>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-6 py-16 text-center text-slate-500">
            <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
            <p class="text-lg font-medium">Tidak ada kamar</p>
            <p class="text-sm text-slate-400">Silakan tambahkan kamar baru untuk memulai</p>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<script>
// Make all room rows clickable
document.addEventListener('DOMContentLoaded', function() {
  const rows = document.querySelectorAll('.room-row');
  rows.forEach(row => {
    row.addEventListener('click', function(e) {
      // Don't navigate if clicking on action buttons
      if (!e.target.closest('.action-buttons')) {
        window.location.href = this.getAttribute('data-url');
      }
    });
  });
});
</script>
@endsection
