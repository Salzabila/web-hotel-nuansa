@extends('layouts.app')

@section('content')
<div>
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold"><i class="fas fa-chart-line mr-2 text-orange-600"></i>Rekapitulasi Tahunan</h1>
  </div>

  <!-- Year Picker -->
  <div class="bg-white p-4 rounded shadow mb-6">
    <form method="GET" action="{{ route('recaps.yearly') }}" class="flex gap-3">
      <input type="number" name="year" value="{{ $year }}" min="2000" max="2100" class="border px-3 py-2 rounded w-32">
      <button class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Cari Tahun</button>
    </form>
    <div class="text-sm text-gray-600 mt-2">
      Tahun: {{ $year }}
    </div>
  </div>

  <!-- Yearly Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Total Pemasukan Tahunan</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
      <div class="text-xs mt-2 opacity-80">{{ $totalIncome > 0 ? 'Rata-rata: Rp ' . number_format($totalIncome / 12, 0, ',', '.') . '/bulan' : '' }}</div>
    </div>
    <div class="bg-gradient-to-br from-red-400 to-red-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Total Pengeluaran Tahunan</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
      <div class="text-xs mt-2 opacity-80">{{ $totalExpense > 0 ? 'Rata-rata: Rp ' . number_format($totalExpense / 12, 0, ',', '.') . '/bulan' : '' }}</div>
    </div>
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Profit/Rugi Tahunan</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
      <div class="text-xs mt-2 opacity-80">Margin: {{ $totalIncome > 0 ? round((($totalIncome - $totalExpense) / $totalIncome) * 100, 1) : 0 }}%</div>
    </div>
  </div>

  <!-- Monthly Breakdown -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Chart-like visual -->
    <div class="bg-white rounded shadow overflow-hidden">
      <div class="bg-gray-700 text-white p-4">
        <h2 class="text-xl font-bold"><i class="fas fa-chart-bar mr-2"></i>Grafik Perbandingan</h2>
      </div>
      <div class="p-6">
        @foreach($monthlyData as $data)
          @php
            $maxValue = max(
              collect($monthlyData)->pluck('income')->max(),
              collect($monthlyData)->pluck('expense')->max()
            );
            $incomePercent = $maxValue > 0 ? ($data['income'] / $maxValue) * 100 : 0;
            $expensePercent = $maxValue > 0 ? ($data['expense'] / $maxValue) * 100 : 0;
          @endphp
          <div class="mb-4">
            <div class="text-sm font-semibold mb-1">{{ $data['month'] }}</div>
            <div class="flex gap-2 h-8">
              <div class="bg-green-400 rounded" style="width: {{ $incomePercent }}%; min-width: 5%;" title="Pemasukan: Rp {{ number_format($data['income'], 0) }}"></div>
              <div class="bg-red-400 rounded" style="width: {{ $expensePercent }}%; min-width: 5%;" title="Pengeluaran: Rp {{ number_format($data['expense'], 0) }}"></div>
            </div>
            <div class="text-xs text-gray-600 mt-1">
              Rp {{ number_format($data['income'], 0, ',', '.') }} - Rp {{ number_format($data['expense'], 0, ',', '.') }}
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Monthly Table -->
    <div class="bg-white rounded shadow overflow-hidden">
      <div class="bg-gray-700 text-white p-4">
        <h2 class="text-xl font-bold"><i class="fas fa-table mr-2"></i>Tabel Bulanan</h2>
      </div>
      <div class="overflow-y-auto max-h-96">
        <table class="w-full text-sm">
          <thead class="bg-gray-200 sticky top-0">
            <tr>
              <th class="p-2 text-left">Bulan</th>
              <th class="p-2 text-right">Pemasukan</th>
              <th class="p-2 text-right">Pengeluaran</th>
              <th class="p-2 text-right">Profit</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @foreach($monthlyData as $data)
              <tr class="hover:bg-gray-50">
                <td class="p-2 font-semibold">{{ $data['month'] }}</td>
                <td class="p-2 text-right text-green-600">Rp {{ number_format($data['income'], 0, ',', '.') }}</td>
                <td class="p-2 text-right text-red-600">Rp {{ number_format($data['expense'], 0, ',', '.') }}</td>
                <td class="p-2 text-right font-semibold" style="color: {{ $data['profit'] >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)' }}">
                  Rp {{ number_format($data['profit'], 0, ',', '.') }}
                </td>
              </tr>
            @endforeach
            <tr class="bg-gray-100 font-bold border-t-2">
              <td class="p-2">TOTAL</td>
              <td class="p-2 text-right text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
              <td class="p-2 text-right text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
              <td class="p-2 text-right" style="color: {{ ($totalIncome - $totalExpense) >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)' }}">
                Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
