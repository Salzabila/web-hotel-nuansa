@extends('layouts.app')

@section('title', 'Biaya Operasional - Hotel Nuansa')
@section('page_title', 'Pengeluaran')

@section('content')
<div class="space-y-6">

  <!-- TOP HEADER & ACTION -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Pengeluaran Operasional</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">Kelola dan pantau seluruh pos pengeluaran operasional hotel</p>
    </div>

    <a href="{{ route('expenses.create') }}" 
       class="inline-flex items-center gap-2 bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition-all self-start sm:self-auto active:scale-95">
      <i class="fas fa-plus"></i>
      <span>Catat Pengeluaran</span>
    </a>
  </div>

  <!-- SUMMARY CARDS -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Total Pengeluaran (Tercatat)</p>
        <h3 class="text-2xl font-black text-[#0B192C] mt-1">
          Rp {{ number_format(\App\Models\Expense::sum('amount'), 0, ',', '.') }}
        </h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Akumulasi pengeluaran</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
        <i class="fas fa-receipt text-base"></i>
      </div>
    </div>

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Bulan Ini</p>
        <h3 class="text-2xl font-black text-[#1D58B8] mt-1">
          Rp {{ number_format(\App\Models\Expense::whereYear('date', date('Y'))->whereMonth('date', date('m'))->sum('amount'), 0, ',', '.') }}
        </h3>
        <p class="text-[11px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-[#1D58B8]">
        <i class="fas fa-calendar-alt text-base"></i>
      </div>
    </div>

    <div class="bg-white rounded-3xl p-5 shadow-sm border border-stone-200/50 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-400">Total Transaksi Biaya</p>
        <h3 class="text-2xl font-black text-[#0B192C] mt-1">
          {{ \App\Models\Expense::count() }} Item
        </h3>
        <p class="text-[11px] text-slate-400 mt-0.5">Pos pengeluaran terdata</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-stone-100 flex items-center justify-center text-slate-600">
        <i class="fas fa-list-check text-base"></i>
      </div>
    </div>
  </div>

  <!-- SEARCH & FILTER CARD -->
  <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/50">
    <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cari Deskripsi</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan biaya..."
               class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400">
      </div>

      <div>
        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Kategori</label>
        <select name="category" 
                class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
          <option value="">Semua Kategori</option>
          <option value="utilities" {{ request('category') === 'utilities' ? 'selected' : '' }}>Utilities (Listrik/Air/Internet)</option>
          <option value="maintenance" {{ request('category') === 'maintenance' ? 'selected' : '' }}>Maintenance (Perawatan)</option>
          <option value="supplies" {{ request('category') === 'supplies' ? 'selected' : '' }}>Supplies (Perlengkapan/Linen)</option>
          <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other (Lainnya)</option>
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
          <i class="fas fa-search mr-1.5"></i> Filter Pengeluaran
        </button>
        <a href="{{ route('expenses.index') }}" 
           class="bg-stone-100 hover:bg-stone-200 text-slate-700 font-bold px-5 py-2.5 rounded-full text-xs transition-all">
          Reset
        </a>
      </div>
    </form>
  </div>

  <!-- EXPENSES LIST TABLE -->
  <div class="bg-white rounded-3xl shadow-sm border border-stone-200/50 overflow-hidden">
    <div class="p-6 border-b border-stone-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-[#0B192C]">Riwayat Pengeluaran</h3>
      <span class="text-xs font-semibold text-slate-400">{{ $expenses->total() }} Data Ditemukan</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs md:text-sm">
        <thead class="bg-[#F8F5EF] text-slate-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-6">Tanggal</th>
            <th class="py-3.5 px-6">Kategori</th>
            <th class="py-3.5 px-6">Deskripsi</th>
            <th class="py-3.5 px-6">Jumlah</th>
            <th class="py-3.5 px-6 text-right">Dicatat Oleh</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100 font-medium">
          @forelse($expenses as $exp)
            <tr class="hover:bg-[#FBF9F5] transition-colors">
              <td class="py-4 px-6 text-slate-600 whitespace-nowrap">
                {{ \Carbon\Carbon::parse($exp->date)->isoFormat('D MMM YYYY') }}
              </td>
              <td class="py-4 px-6">
                @if($exp->category === 'utilities')
                  <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full text-[11px] uppercase">Utilities</span>
                @elseif($exp->category === 'maintenance')
                  <span class="bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full text-[11px] uppercase">Maintenance</span>
                @elseif($exp->category === 'supplies')
                  <span class="bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full text-[11px] uppercase">Supplies</span>
                @else
                  <span class="bg-slate-100 text-slate-700 font-bold px-3 py-1 rounded-full text-[11px] uppercase">Other</span>
                @endif
              </td>
              <td class="py-4 px-6 text-[#0B192C] font-semibold">
                {{ $exp->description ?: '-' }}
              </td>
              <td class="py-4 px-6 font-extrabold text-[#0B192C] whitespace-nowrap">
                Rp {{ number_format($exp->amount, 0, ',', '.') }}
              </td>
              <td class="py-4 px-6 text-right text-slate-500 whitespace-nowrap">
                {{ $exp->user->name ?? 'Admin' }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-slate-400 text-xs font-medium">
                Belum ada pengeluaran yang dicatat.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($expenses->hasPages())
      <div class="p-5 border-t border-stone-100 bg-[#F8F5EF]">
        {{ $expenses->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
