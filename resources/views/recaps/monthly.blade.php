@extends('layouts.app')

@section('content')
<div>
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold"><i class="fas fa-calendar-alt mr-2 text-green-600"></i>Rekapitulasi Bulanan</h1>
  </div>

  <!-- Month Picker -->
  <div class="bg-white p-4 rounded shadow mb-6">
    <form method="GET" action="{{ route('recaps.monthly') }}" class="flex gap-3">
      <input type="month" name="date" value="{{ $date }}" class="border px-3 py-2 rounded">
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Cari Bulan</button>
    </form>
    <div class="text-sm text-gray-600 mt-2">
      Bulan: {{ $monthName }}
    </div>
  </div>

  <!-- Monthly Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Total Pemasukan</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
    </div>
    <div class="bg-gradient-to-br from-red-400 to-red-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Total Pengeluaran</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
    </div>
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Profit/Rugi</div>
      <div class="text-3xl font-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</div>
    </div>
  </div>

  <!-- Daily Table -->
  <div class="bg-white rounded shadow overflow-hidden">
    <div class="bg-gray-700 text-white p-4">
      <h2 class="text-xl font-bold"><i class="fas fa-list-ul mr-2"></i>Perincian Harian</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-200 sticky top-0">
          <tr>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-right">Pemasukan</th>
            <th class="p-3 text-right">Pengeluaran</th>
            <th class="p-3 text-right">Profit</th>
            <th class="p-3 text-center">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($dailyData as $data)
            @php $bgColor = $data['profit'] >= 0 ? 'bg-green-50' : 'bg-red-50'; @endphp
            <tr class="hover:bg-gray-100 {{ $bgColor }}">
              <td class="p-3">
                <a href="{{ route('recaps.daily', ['date' => $data['date']->format('Y-m-d')]) }}" class="text-blue-600 hover:underline">
                  {{ $data['date']->format('d M Y') }} ({{ $data['date']->format('D') }})
                </a>
              </td>
              <td class="p-3 text-right text-green-600 font-semibold">Rp {{ number_format($data['income'], 0, ',', '.') }}</td>
              <td class="p-3 text-right text-red-600 font-semibold">Rp {{ number_format($data['expense'], 0, ',', '.') }}</td>
              <td class="p-3 text-right font-bold" style="color: {{ $data['profit'] >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)' }}">
                Rp {{ number_format($data['profit'], 0, ',', '.') }}
              </td>
              <td class="p-3 text-center">
                @if($data['profit'] > 0)
                  <span class="text-green-600"><i class="fas fa-arrow-up"></i></span>
                @elseif($data['profit'] < 0)
                  <span class="text-red-600"><i class="fas fa-arrow-down"></i></span>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-gray-100 font-bold border-t-2">
          <tr>
            <td class="p-3">TOTAL BULAN</td>
            <td class="p-3 text-right text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            <td class="p-3 text-right text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            <td class="p-3 text-right" style="color: {{ ($totalIncome - $totalExpense) >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)' }}">
              Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
            </td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection
