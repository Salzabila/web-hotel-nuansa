@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Semua Kamar</h1>
    <p class="text-slate-500 mt-2 text-base">Tampilan lengkap semua kamar hotel</p>
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
      @elseif($room->status === 'dirty')
        <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg opacity-90">
          <div class="text-3xl mb-3 font-bold"><i class="fas fa-broom"></i></div>
          <div class="font-bold text-base">{{ $room->room_number }}</div>
          <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
          <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
        </div>
      @elseif(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('rooms.edit', $room) }}" class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1 cursor-pointer">
          <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
          <div class="font-bold text-base">{{ $room->room_number }}</div>
          <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
          <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
        </a>
      @else
        <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg opacity-75">
          <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
          <div class="font-bold text-base">{{ $room->room_number }}</div>
          <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
          <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
        </div>
      @endif
    @endforeach
  </div>

  @if($rooms->isEmpty())
    <div class="text-center py-16">
      <i class="fas fa-inbox text-6xl text-slate-300 mb-4"></i>
      <p class="text-lg font-medium text-slate-500">Tidak ada kamar</p>
      <p class="text-sm text-slate-400">Silakan tambahkan kamar baru untuk memulai</p>
    </div>
  @endif
</div>
@endsection
