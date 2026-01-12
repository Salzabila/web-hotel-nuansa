@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-slate-500 mt-2 text-base">Dashboard Hotel Nuansa</p>
  </div>

  <!-- Summary Stats -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1: Teal -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Total Kamar</p>
          <p class="text-4xl font-bold text-slate-800">{{ $totalRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Kapasitas Hotel</p>
        </div>
        <div class="w-14 h-14 bg-teal-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-door-open text-2xl text-teal-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 2: Emerald -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Kamar Tersedia</p>
          <p class="text-4xl font-bold text-slate-800">{{ $availableRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Siap Ditempati</p>
        </div>
        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 3: Rose -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Kamar Terisi</p>
          <p class="text-4xl font-bold text-slate-800">{{ $occupiedRooms }}</p>
          <p class="text-sm text-slate-400 mt-2">Sedang Dihuni</p>
        </div>
        <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-user text-2xl text-rose-500"></i>
        </div>
      </div>
    </div>

    <!-- Stat Card 4: Blue -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Omset Hari Ini</p>
          <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
          <p class="text-sm text-slate-400 mt-2">Total Pendapatan</p>
        </div>
        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-money-bill-wave text-2xl text-blue-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Room Grid -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Master Kamar</h2>
        <p class="text-slate-500 text-sm mt-1">Status dan ketersediaan kamar</p>
      </div>
      <a href="{{ route('rooms.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-2 hover:underline transition">
        Lihat Semua <i class="fas fa-arrow-right"></i>
      </a>
    </div>
    
    <div class="flex flex-wrap gap-6 mb-6 text-sm bg-gray-50 p-5 rounded-lg">
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-green-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Tersedia</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-red-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Terisi</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="w-6 h-6 bg-yellow-500 rounded-full shadow-md"></span>
        <span class="text-gray-800 font-semibold">Pemeliharaan</span>
      </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      @foreach($rooms as $room)
        @php
          $statusColor = match($room->status) {
            'available' => 'bg-gradient-to-br from-green-400 to-green-600 hover:from-green-500 hover:to-green-700',
            'occupied' => 'bg-gradient-to-br from-red-400 to-red-600 hover:from-red-500 hover:to-red-700',
            'maintenance' => 'bg-gradient-to-br from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700',
            default => 'bg-gradient-to-br from-gray-400 to-gray-600'
          };
          $statusText = match($room->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
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
        @else
          <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center shadow-lg cursor-default">
            <div class="text-3xl mb-3 font-bold"><i class="fas fa-door-open"></i></div>
            <div class="font-bold text-base">{{ $room->room_number }}</div>
            <div class="text-sm opacity-90 mt-2">{{ $room->type }}</div>
            <div class="text-sm opacity-80 mt-2 font-semibold">{{ $statusText }}</div>
          </div>
        @endif
      @endforeach
    </div>
  </div>

  <!-- Active Transactions -->
  <div class="card p-8 rounded-2xl bg-white shadow-lg">
    <div class="mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Transaksi Aktif</h2>
      <p class="text-gray-600 text-sm mt-2">Daftar tamu yang sedang menginap</p>
    </div>
    
    @php
      $activeTransactions = \App\Models\Transaction::with('room', 'user')
        ->where('status', 'active')
        ->orderBy('check_in', 'desc')
        ->limit(10)
        ->get();
    @endphp

    @if($activeTransactions->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
              <th class="text-left py-5 px-6 font-bold text-gray-900">Invoice</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Tamu</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Kamar</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Check-in</th>
              <th class="text-left py-5 px-6 font-bold text-gray-900">Check-out</th>
              <th class="text-right py-5 px-6 font-bold text-gray-900">Total</th>
              <th class="text-center py-5 px-6 font-bold text-gray-900">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($activeTransactions as $tx)
              <tr class="hover:bg-blue-50 transition-colors duration-150 border-b border-gray-100 last:border-0">
                <td class="py-5 px-6 font-bold text-blue-600 text-base">{{ $tx->invoice_code }}</td>
                <td class="py-5 px-6 text-gray-900 font-semibold">{{ $tx->guest_name }}</td>
                <td class="py-5 px-6 text-gray-900 font-medium">{{ $tx->room->room_number }}</td>
                <td class="py-5 px-6 text-gray-700">{{ $tx->check_in->format('d/m/y H:i') }}</td>
                <td class="py-5 px-6 text-gray-700">
                  @if($tx->check_out)
                    {{ $tx->check_out->format('d/m/y H:i') }}
                  @else
                    <span class="text-yellow-600 font-semibold">Menginap</span>
                  @endif
                </td>
                <td class="py-5 px-6 text-right font-bold text-gray-900">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                <td class="py-5 px-6 text-center">
                  <a href="{{ route('transactions.checkout', $tx->id) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-bold text-xs px-4 py-2 rounded-lg transition shadow-md hover:shadow-lg">
                    <i class="fas fa-sign-out-alt"></i>Checkout
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="text-center py-12 text-gray-500">
        <i class="fas fa-inbox text-4xl mb-4 opacity-30"></i>
        <p class="text-lg">Tidak ada transaksi aktif saat ini</p>
      </div>
    @endif
  </div>
</div>
@endsection
