@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-slate-500 mt-2 text-base">Dashboard Kasir - Hotel Nuansa</p>
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
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Status Kamar</h2>
        <p class="text-slate-500 text-sm mt-1">Lihat ketersediaan kamar</p>
      </div>
      <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg">
        <i class="fas fa-external-link-alt"></i> Lihat Semua
      </a>
    </div>
    
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

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      @foreach($rooms->take(8) as $room)
        @php
          $statusColor = match($room->status) {
            'available' => 'bg-green-500',
            'occupied' => 'bg-red-500',
            'dirty' => 'bg-slate-400',
            'maintenance' => 'bg-yellow-500',
            default => 'bg-gray-400'
          };
          
          // Find active transaction for occupied rooms
          $activeTransaction = null;
          if ($room->status === 'occupied') {
            $activeTransaction = \App\Models\Transaction::where('room_id', $room->id)
              ->where('status', 'active')
              ->first();
          }
        @endphp
        
        @if($room->status === 'available')
          {{-- Green: Link to Check-in --}}
          <a href="{{ route('transactions.create', $room->id) }}" 
             class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
            <div class="text-3xl font-black mb-1">{{ $room->room_number }}</div>
            <div class="text-xs opacity-90 font-medium">{{ $room->type }}</div>
          </a>
          
        @elseif($room->status === 'occupied' && $activeTransaction)
          {{-- Red: Link to Check-out --}}
          <a href="{{ route('transactions.checkout', $activeTransaction->id) }}" 
             class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
            <div class="text-3xl font-black mb-1">{{ $room->room_number }}</div>
            <div class="text-xs opacity-90 font-medium">{{ $room->type }}</div>
            <div class="text-xs opacity-75 mt-1">
              <i class="fas fa-arrow-right-from-bracket"></i> Check-out
            </div>
          </a>
          
        @elseif($room->status === 'dirty')
          {{-- Gray: Mark as Clean --}}
          <form action="{{ route('rooms.markClean', $room->id) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" 
                    style="background-color: rgb(148 163 184) !important;"
                    class="text-slate-800 rounded-xl p-5 text-center transition shadow-lg hover:shadow-2xl transform hover:-translate-y-1 w-full hover:bg-slate-500 hover:text-white">
              <div class="text-3xl font-black mb-1">{{ $room->room_number }}</div>
              <div class="text-xs opacity-90 font-medium">{{ $room->type }}</div>
              <div class="text-xs opacity-75 mt-1">
                <i class="fas fa-broom"></i> Tandai Bersih
              </div>
            </button>
          </form>
          
        @else
          {{-- Yellow (Maintenance): Read-only --}}
          <div class="{{ $statusColor }} text-white rounded-xl p-5 text-center transition shadow-lg opacity-75">
            <div class="text-3xl font-black mb-1">{{ $room->room_number }}</div>
            <div class="text-xs opacity-90 font-medium">{{ $room->type }}</div>
          </div>
        @endif
      @endforeach
    </div>
  </div>

  <!-- Active Transactions -->
  <div class="card p-8 rounded-2xl bg-white shadow-sm border border-slate-100">
    <div class="mb-6">
      <h2 class="text-xl font-bold text-slate-800">Transaksi Aktif</h2>
      <p class="text-slate-500 text-sm mt-1">Pelanggan yang sedang menginap</p>
    </div>

    @if($activeTransactionsList->isEmpty())
      <div class="text-center py-12">
        <i class="fas fa-bed text-6xl text-slate-300 mb-4"></i>
        <p class="text-slate-500 font-medium">Tidak ada pelanggan yang menginap saat ini</p>
        <p class="text-slate-400 text-sm">Transaksi aktif akan muncul di sini</p>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b-2 border-slate-200">
              <th class="text-left py-4 px-4 font-bold text-slate-600 text-sm">Invoice</th>
              <th class="text-left py-4 px-4 font-bold text-slate-600 text-sm">Pelanggan</th>
              <th class="text-left py-4 px-4 font-bold text-slate-600 text-sm">Kamar</th>
              <th class="text-left py-4 px-4 font-bold text-slate-600 text-sm">Check-in</th>
              <th class="text-right py-4 px-4 font-bold text-slate-600 text-sm">Total</th>
              <th class="text-center py-4 px-4 font-bold text-slate-600 text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($activeTransactionsList as $tx)
              <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                <td class="py-4 px-4 font-semibold text-blue-600 text-sm">{{ $tx->invoice_code }}</td>
                <td class="py-4 px-4 text-slate-700 text-sm">{{ $tx->guest_name }}</td>
                <td class="py-4 px-4 text-slate-700 text-sm">{{ $tx->room->room_number }}</td>
                <td class="py-4 px-4 text-slate-500 text-sm">{{ $tx->check_in->format('d/m/y H:i') }}</td>
                <td class="py-4 px-4 text-right font-semibold text-slate-800 text-sm">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                <td class="py-4 px-4 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <a href="{{ route('transactions.show', $tx->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors border border-slate-200" title="Detail">
                      <i class="fas fa-eye text-sm"></i>
                    </a>
                    <a href="{{ route('transactions.checkout', $tx->id) }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition-all shadow-md" title="Check-out">
                      <i class="fas fa-sign-out-alt"></i> Check-out
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
