@extends('layouts.app')

@section('content')
<div>
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold"><i class="fas fa-receipt mr-2"></i>Laporan Transaksi</h1>
    <a href="{{ route('reports.exportTransactions') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      <i class="fas fa-download mr-2"></i>Export CSV
    </a>
  </div>

  <!-- Filter -->
  <div class="bg-white p-4 rounded shadow mb-6">
    <div class="grid grid-cols-3 gap-4">
      <div class="text-center p-4 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded">
        <div class="text-sm opacity-80">Total Transaksi</div>
        <div class="text-3xl font-bold">{{ $transactions->total() }}</div>
      </div>
      <div class="text-center p-4 bg-gradient-to-br from-green-400 to-green-600 text-white rounded">
        <div class="text-sm opacity-80">Transaksi Selesai</div>
        <div class="text-3xl font-bold">{{ $transactions->where('status','finished')->count() }}</div>
      </div>
      <div class="text-center p-4 bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded">
        <div class="text-sm opacity-80">Total Pemasukan</div>
        <div class="text-3xl font-bold">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white rounded shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-700 text-white">
          <tr>
            <th class="p-3 text-left">Pelanggan</th>
            <th class="p-3 text-left">NIK</th>
            <th class="p-3 text-left">Kamar</th>
            <th class="p-3 text-left">Check-in</th>
            <th class="p-3 text-left">Check-out</th>
            <th class="p-3 text-right">Total</th>
            <th class="p-3 text-center">Status</th>
            <th class="p-3 text-center">KTP</th>
            <th class="p-3 text-center">Rating</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($transactions as $tx)
            <tr class="hover:bg-gray-50 transition">
              <td class="p-3">{{ $tx->guest_name }}</td>
              <td class="p-3 text-sm">{{ $tx->nik }}</td>
              <td class="p-3"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $tx->room->room_number }}</span></td>
              <td class="p-3 text-sm">{{ $tx->check_in->format('d/m/Y H:i') }}</td>
              <td class="p-3 text-sm">{{ $tx->check_out->format('d/m/Y H:i') }}</td>
              <td class="p-3 text-right font-semibold">Rp {{ number_format($tx->total_price,0,',','.') }}</td>
              <td class="p-3 text-center">
                <span class="px-2 py-1 rounded text-sm {{ $tx->status === 'finished' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                  {{ $tx->status === 'finished' ? 'Selesai' : 'Aktif' }}
                </span>
              </td>
              <td class="p-3 text-center">
                @if($tx->is_ktp_held)
                  <i class="fas fa-check-circle text-red-500"></i>
                @else
                  <i class="fas fa-times text-gray-300"></i>
                @endif
              </td>
              <td class="p-3 text-center">
                @if($tx->feedback)
                  <span class="text-yellow-500">{{ str_repeat('★', $tx->feedback->rating) }}</span>
                @else
                  <a href="{{ route('feedbacks.create', $tx->id) }}" class="text-blue-600 hover:underline text-sm">Beri Rating</a>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="p-4 text-center text-gray-500">Tidak ada transaksi.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-6">
    {{ $transactions->links() }}
  </div>
</div>
@endsection
