@extends('layouts.app')

@section('title', 'Riwayat Transaksi - Hotel Nuansa')
@section('page_title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-6">

  <!-- TOP HEADER & EXPORT ACTIONS -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Riwayat Transaksi</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">Daftar rekapan transaksi check-in dan checkout hotel</p>
    </div>

    <!-- Export Buttons -->
    <div class="flex items-center gap-2.5 self-start sm:self-auto">
      <a href="{{ route('export.transactions.pdf') }}" target="_blank"
         class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2">
        <i class="fas fa-file-pdf text-rose-500"></i>
        <span>PDF</span>
      </a>
      <a href="{{ route('export.transactions.excel') }}"
         class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2">
        <i class="fas fa-file-excel text-emerald-600"></i>
        <span>Excel</span>
      </a>
    </div>
  </div>

  <!-- SEARCH & FILTER CARD -->
  <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50">
    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cari Tamu / Invoice</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau no invoice..."
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400">
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status Transaksi</label>
        <select name="status" 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="">Semua Status</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Sedang Menginap)</option>
          <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Selesai (Sudah Checkout)</option>
        </select>
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400">
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400">
      </div>

      <div class="sm:col-span-2 lg:col-span-4 flex items-center gap-3 pt-2">
        <button type="submit" 
                class="bg-[#0B192C] hover:bg-[#152e4d] text-white font-bold px-6 py-2.5 rounded-full text-xs shadow-md transition-all">
          <i class="fas fa-search mr-1.5"></i> Filter Riwayat
        </button>
        <a href="{{ route('transactions.index') }}" 
           class="bg-stone-100 hover:bg-stone-200 text-slate-700 font-bold px-5 py-2.5 rounded-full text-xs transition-all">
          Reset
        </a>
      </div>
    </form>
  </div>

  <!-- TRANSACTIONS TABLE -->
  <div class="bg-white rounded-3xl shadow-sm border border-stone-200/50 overflow-hidden">
    <div class="p-6 border-b border-stone-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-[#0B192C]">Daftar Transaksi</h3>
      <span class="text-xs font-semibold text-slate-400">{{ $transactions->total() }} Transaksi</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs md:text-sm">
        <thead class="bg-[#F8F5EF] text-slate-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-6">Invoice</th>
            <th class="py-3.5 px-6">Nama Tamu</th>
            <th class="py-3.5 px-6">Kamar</th>
            <th class="py-3.5 px-6">Check-in</th>
            <th class="py-3.5 px-6">Check-out</th>
            <th class="py-3.5 px-6">Metode</th>
            <th class="py-3.5 px-6">Total</th>
            <th class="py-3.5 px-6 text-center">Status</th>
            <th class="py-3.5 px-6 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100 font-medium">
          @forelse($transactions as $tx)
            <tr class="hover:bg-[#FBF9F5] transition-colors">
              <td class="py-4 px-6 font-extrabold text-[#0B192C] whitespace-nowrap">
                {{ $tx->invoice_code }}
              </td>
              <td class="py-4 px-6 text-[#0B192C]">
                <div class="font-bold">{{ $tx->guest_name }}</div>
                @if(!$tx->is_guest_data_complete)
                  <span class="bg-rose-100 text-rose-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full inline-flex items-center gap-1 border border-rose-200 mt-1">
                    <i class="fas fa-exclamation-triangle text-rose-500"></i> Belum Lengkap
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 whitespace-nowrap">
                <span class="bg-stone-100 text-[#0B192C] font-bold px-2.5 py-1 rounded-xl text-xs">
                  {{ $tx->room->room_number ?? '-' }}
                </span>
              </td>
              <td class="py-4 px-6 text-slate-600 whitespace-nowrap text-xs">
                {{ $tx->check_in ? $tx->check_in->isoFormat('D MMM Y, HH:mm') : '-' }}
              </td>
              <td class="py-4 px-6 text-slate-600 whitespace-nowrap text-xs">
                <div>{{ $tx->check_out ? $tx->check_out->isoFormat('D MMM Y, HH:mm') : '-' }}</div>
                @if($tx->status === 'active')
                  @if($tx->checkout_urgency === 'overdue')
                    <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-2xs mt-1 animate-pulse">
                      <i class="fas fa-clock"></i> {{ $tx->checkout_countdown_text }}
                    </span>
                  @elseif($tx->checkout_urgency === 'imminent')
                    <span class="bg-amber-400 text-[#0B192C] text-[10px] font-extrabold px-2 py-0.5 rounded-full inline-flex items-center gap-1 shadow-2xs mt-1">
                      <i class="fas fa-hourglass-half"></i> {{ $tx->checkout_countdown_text }}
                    </span>
                  @elseif($tx->checkout_urgency === 'today')
                    <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1 mt-1">
                      CO Hari Ini
                    </span>
                  @endif
                @endif
              </td>
              <td class="py-4 px-6 text-slate-600 whitespace-nowrap text-xs">
                {{ $tx->paymentMethod->bank_name ?? $tx->paymentMethod->name ?? 'Cash' }}
              </td>
              <td class="py-4 px-6 font-extrabold text-[#0B192C] whitespace-nowrap">
                Rp {{ number_format($tx->total_price, 0, ',', '.') }}
              </td>
              <td class="py-4 px-6 text-center whitespace-nowrap">
                @if($tx->status === 'active')
                  <span class="bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full text-[11px]">
                    Aktif
                  </span>
                @else
                  <span class="bg-[#DCFCE7] text-[#16A34A] font-bold px-3 py-1 rounded-full text-[11px]">
                    Selesai
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-2 justify-end">
                  @if(!$tx->is_guest_data_complete)
                    <a href="{{ route('transactions.guestBook', $tx->id) }}"
                       class="bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300 font-extrabold px-3 py-1.5 rounded-full text-xs transition-all flex items-center gap-1 shadow-2xs"
                       title="Lengkapi Buku Tamu Digital">
                      <i class="fas fa-edit text-amber-600"></i>
                      <span>Isi Data</span>
                    </a>
                  @endif

                  @if($tx->status === 'active')
                    <!-- Buka checkout di Front Office -->
                    <a href="{{ route('checkin', ['tx_id' => $tx->id]) }}" 
                       class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-3 py-1.5 rounded-full text-xs transition-all shadow-xs"
                       title="Proses Checkout">
                      Checkout
                    </a>
                  @else
                    <!-- Cetak Struk -->
                    <a href="{{ route('transactions.struk', $tx->id) }}" target="_blank"
                       class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-700 flex items-center justify-center transition-all"
                       title="Cetak Struk">
                      <i class="fas fa-print text-xs"></i>
                    </a>
                  @endif

                  <!-- Detail -->
                  <a href="{{ route('transactions.show', $tx->id) }}" 
                     class="w-8 h-8 rounded-full bg-blue-50 hover:bg-blue-100 text-[#1D58B8] flex items-center justify-center transition-all"
                     title="Lihat Rincian">
                    <i class="fas fa-eye text-xs"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="py-12 text-center text-slate-400 text-xs font-medium">
                Tidak ada data transaksi yang sesuai filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($transactions->hasPages())
      <div class="p-5 border-t border-stone-100 bg-[#F8F5EF]">
        {{ $transactions->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
