@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Riwayat Transaksi</h1>
    <p class="text-slate-500 mt-2 text-base">Daftar semua transaksi hotel</p>
  </div>

  <!-- Search & Filter Bar -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Cari Nama/Invoice</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau invoice..." class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Status</label>
        <select name="status" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
          <option value="">Semua Status</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
          <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Selesai</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Dari Tanggal</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wider">Sampai Tanggal</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
      </div>
      <div class="md:col-span-4 flex gap-3">
        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-md flex items-center gap-2">
          <i class="fas fa-search"></i> Cari
        </button>
        <a href="{{ route('transactions.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all flex items-center gap-2">
          <i class="fas fa-redo"></i> Refresh
        </a>
      </div>
    </form>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="text-left py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Invoice</th>
            <th class="text-left py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Pelanggan</th>
            <th class="text-left py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Kamar</th>
            <th class="text-left py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Check-in</th>
            <th class="text-left py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Check-out</th>
            <th class="text-right py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Total</th>
            <th class="text-center py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Status</th>
            <th class="text-center py-4 px-6 font-bold text-slate-400 text-xs uppercase tracking-wider bg-transparent">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $tx)
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
              <td class="py-4 px-6 font-semibold text-blue-600 text-sm">{{ $tx->invoice_code }}</td>
              <td class="py-4 px-6 text-slate-700 text-sm">{{ $tx->guest_name }}</td>
              <td class="py-4 px-6 text-slate-700 text-sm">{{ $tx->room->room_number }}</td>
              <td class="py-4 px-6 text-slate-500 text-sm">{{ $tx->check_in->format('d/m/y H:i') }}</td>
              <td class="py-4 px-6 text-slate-500 text-sm">
                @if($tx->check_out)
                  {{ $tx->check_out->format('d/m/y H:i') }}
                @else
                  <span class="text-slate-400 italic">Belum checkout</span>
                @endif
              </td>
              <td class="py-4 px-6 text-right font-semibold text-slate-800 text-sm">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
              <td class="py-4 px-6 text-center">
                @if($tx->status === 'active')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100">Aktif</span>
                @elseif($tx->status === 'finished')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Selesai</span>
                @endif
              </td>
              <td class="py-4 px-6 text-center">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('transactions.show', $tx->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors border border-slate-200" title="Detail">
                    <i class="fas fa-eye text-sm"></i>
                  </a>
                  <a href="{{ route('transactions.struk', $tx->id) }}" target="_blank" class="inline-flex items-center justify-center w-9 h-9 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-200" title="Cetak Struk">
                    <i class="fas fa-receipt text-sm"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="py-12 text-center">
                <i class="fas fa-inbox text-5xl text-slate-300 mb-3 block"></i>
                <p class="text-slate-500 font-medium">Tidak ada transaksi</p>
                <p class="text-slate-400 text-sm mt-1">Transaksi akan muncul di sini</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
      {{ $transactions->links('pagination::simple-bootstrap-5') }}
    </div>
  </div>
</div>
@endsection
