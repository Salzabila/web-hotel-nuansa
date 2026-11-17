@extends('layouts.app')

@section('title', 'Laporan & Pengeluaran - Hotel Nuansa')
@section('page_title', 'Laporan & Pengeluaran')

@section('content')
<div class="space-y-6">

  <!-- TOP BAR: PILL TABS & EXPORT BUTTONS -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <!-- Left: Period Pill Tabs -->
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('reports.finance', ['period' => 'harian', 'category' => $selectedCategory]) }}"
         class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $period === 'harian' ? 'bg-[#0B192C] text-white shadow-md' : 'bg-white border border-stone-200 text-slate-700 hover:bg-stone-50' }}">
        Harian
      </a>
      <a href="{{ route('reports.finance', ['period' => 'mingguan', 'category' => $selectedCategory]) }}"
         class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $period === 'mingguan' ? 'bg-[#0B192C] text-white shadow-md' : 'bg-white border border-stone-200 text-slate-700 hover:bg-stone-50' }}">
        Mingguan
      </a>
      <a href="{{ route('reports.finance', ['period' => 'bulanan', 'category' => $selectedCategory]) }}"
         class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $period === 'bulanan' ? 'bg-[#0B192C] text-white shadow-md' : 'bg-white border border-stone-200 text-slate-700 hover:bg-stone-50' }}">
        Bulanan
      </a>
      <a href="{{ route('reports.finance', ['period' => 'tahunan', 'category' => $selectedCategory]) }}"
         class="px-5 py-2 rounded-full text-xs font-bold transition-all {{ $period === 'tahunan' ? 'bg-[#0B192C] text-white shadow-md' : 'bg-white border border-stone-200 text-slate-700 hover:bg-stone-50' }}">
        Tahunan
      </a>
    </div>

    <!-- Right: Export Buttons (PDF, Excel, CSV) -->
    <div class="flex items-center gap-2.5">
      <a href="{{ route('export.financial.pdf') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}" 
         target="_blank"
         class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2">
        <i class="fas fa-file-pdf text-rose-500"></i>
        <span>PDF</span>
      </a>
      <a href="{{ route('export.financial.excel') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}"
         class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2">
        <i class="fas fa-file-excel text-emerald-600"></i>
        <span>Excel</span>
      </a>
      <a href="{{ route('recaps.export') }}?date={{ $startDate->format('Y-m-d') }}"
         class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2 rounded-full text-xs shadow-xs transition-all flex items-center gap-2">
        <i class="fas fa-file-csv text-blue-600"></i>
        <span>CSV</span>
      </a>
    </div>

  </div>

  <!-- 2-COLUMN CONTENT GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- LEFT COLUMN: LAPORAN KEUANGAN (Col 6) -->
    <div class="lg:col-span-6 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50 flex flex-col justify-between">
      <div>
        <h3 class="text-base md:text-lg font-bold text-[#0B192C] mb-6">Laporan Keuangan</h3>

        <!-- Financial Breakdown List -->
        <div class="divide-y divide-stone-100 text-xs md:text-sm">
          
          <div class="py-4 flex justify-between items-center">
            <span class="text-slate-600 font-medium">Pendapatan Kotor</span>
            <span class="font-bold text-[#0B192C]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
          </div>

          <div class="py-4 flex justify-between items-center">
            <span class="text-slate-600 font-medium">Beban Operasional</span>
            <span class="font-bold text-[#0B192C]">Rp {{ number_format($rawExpenseTotal, 0, ',', '.') }}</span>
          </div>

          <div class="py-4 flex justify-between items-center">
            <span class="text-slate-600 font-medium">Komisi TC</span>
            <span class="font-bold text-[#0B192C]">Rp {{ number_format($totalTCCommission, 0, ',', '.') }}</span>
          </div>

          <div class="py-4 flex justify-between items-center">
            <span class="text-slate-600 font-medium">Biaya Operasional Tambahan</span>
            <span class="font-bold text-[#0B192C]">Rp {{ number_format($operationalCost, 0, ',', '.') }}</span>
          </div>

          <div class="py-4 flex justify-between items-center">
            <span class="text-slate-600 font-medium">Estimasi Gaji Karyawan</span>
            <span class="font-bold text-[#0B192C]">Rp {{ number_format($employeeSalary, 0, ',', '.') }}</span>
          </div>

          <div class="py-5 flex justify-between items-center text-sm md:text-base border-t-2 border-stone-200">
            <span class="font-extrabold text-[#0B192C]">Laba Bersih</span>
            <span class="font-black text-[#1D58B8] text-base md:text-lg">
              Rp {{ number_format($netProfit, 0, ',', '.') }}
            </span>
          </div>

        </div>
      </div>

      <!-- Quick Adjustment Info -->
      <div class="mt-6 p-4 rounded-2xl bg-[#F8F5EF] flex items-center justify-between text-xs text-slate-500">
        <span>Periode: <strong>{{ $startDate->isoFormat('D MMM YYYY') }} - {{ $endDate->isoFormat('D MMM YYYY') }}</strong></span>
        <span>Total Tamu: <strong class="text-slate-800">{{ $totalCustomers }}</strong></span>
      </div>
    </div>

    <!-- RIGHT COLUMN: PENGELUARAN OPERASIONAL & ULASAN TAMU (Col 6) -->
    <div class="lg:col-span-6 space-y-6">

      <!-- CARD: PENGELUARAN OPERASIONAL -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <h3 class="text-base md:text-lg font-bold text-[#0B192C] mb-5">Pengeluaran Operasional</h3>

        <!-- Filter Controls -->
        <form method="GET" action="{{ route('reports.finance') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-5">
          <input type="hidden" name="period" value="{{ $period }}">
          
          <div>
            <label class="block text-[11px] font-bold text-slate-500 mb-1">Kategori</label>
            <select name="category" onchange="this.form.submit()"
                    class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
              <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>Semua Kategori</option>
              <option value="utilities" {{ $selectedCategory === 'utilities' ? 'selected' : '' }}>Utilities</option>
              <option value="maintenance" {{ $selectedCategory === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
              <option value="supplies" {{ $selectedCategory === 'supplies' ? 'selected' : '' }}>Supplies</option>
              <option value="other" {{ $selectedCategory === 'other' ? 'selected' : '' }}>Other</option>
            </select>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-slate-500 mb-1">Rentang tanggal</label>
            <div class="flex items-center gap-1.5">
              <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" onchange="this.form.submit()"
                     class="w-1/2 px-2.5 py-2 rounded-xl border border-stone-200 text-[11px] bg-white focus:outline-none">
              <span class="text-slate-400 text-xs">-</span>
              <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" onchange="this.form.submit()"
                     class="w-1/2 px-2.5 py-2 rounded-xl border border-stone-200 text-[11px] bg-white focus:outline-none">
            </div>
          </div>
        </form>

        <!-- Expenses List / Table -->
        <div class="space-y-2.5 max-h-[220px] overflow-y-auto pr-1">
          @forelse($expensesList as $exp)
            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8F5EF] text-xs">
              <div class="flex items-center gap-3">
                <span class="font-bold text-[#0B192C] capitalize min-w-[85px]">{{ $exp->category }}</span>
                <span class="text-slate-500 truncate max-w-[140px] md:max-w-[200px]">{{ $exp->description ?: '-' }}</span>
              </div>
              <strong class="text-slate-900 font-extrabold whitespace-nowrap">
                Rp {{ number_format($exp->amount, 0, ',', '.') }}
              </strong>
            </div>
          @empty
            <div class="py-8 text-center text-slate-400 text-xs font-medium">
              Belum ada data pengeluaran pada rentang tanggal ini.
            </div>
          @endforelse
        </div>
      </div>

      <!-- CARD: ULASAN TAMU -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <h3 class="text-base md:text-lg font-bold text-[#0B192C] mb-3">Ulasan Tamu</h3>

        <!-- Rating Display -->
        <div class="flex items-center gap-2 mb-3">
          <span class="text-2xl md:text-3xl font-black text-[#0B192C] flex items-center gap-1.5">
            <i class="fas fa-star text-[#F5A623] text-xl"></i>
            {{ $avgRatingFormatted }}
          </span>
          <span class="text-xs font-semibold text-slate-400">/ 5</span>
        </div>

        <!-- Latest Comment -->
        <div class="bg-[#F8F5EF] p-4 rounded-2xl">
          <p class="text-xs text-slate-600 italic leading-relaxed">
            @if($latestFeedback)
              "{{ $latestFeedback->comment ?: 'Pelayanan kamar sangat bersih dan staf ramah.' }}"
            @else
              "Pelayanan kamar sangat bersih dan nyaman, proses check-in cepat!"
            @endif
          </p>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
