@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Feedback Pelanggan</h1>
    <p class="text-slate-500 mt-2 text-base">Daftar feedback dari pelanggan hotel</p>
  </div>

  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-check-circle text-xl"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-exclamation-circle text-xl"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Feedback -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Total Feedback</p>
          <p class="text-3xl font-bold text-slate-800">{{ $feedbacks->total() }}</p>
        </div>
        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-comment-dots text-2xl text-blue-500"></i>
        </div>
      </div>
    </div>

    <!-- Average Rating -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Rating Rata-rata</p>
          <p class="text-3xl font-bold text-slate-800">
            {{ number_format(\App\Models\Feedback::avg('rating'), 1) }}
            <span class="text-base text-amber-500">★</span>
          </p>
        </div>
        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-star text-2xl text-amber-500"></i>
        </div>
      </div>
    </div>

    <!-- Feedback Bulan Ini -->
    <div class="bg-white hover:shadow-lg transition-all p-6 rounded-2xl shadow-sm border border-slate-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
          <p class="text-slate-500 text-sm font-medium mb-2">Bulan Ini</p>
          <p class="text-3xl font-bold text-slate-800">
            {{ \App\Models\Feedback::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() }}
          </p>
        </div>
        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
          <i class="fas fa-calendar-check text-2xl text-emerald-500"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Feedback Table -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Feedback</h2>
        <p class="text-slate-500 text-sm mt-1">Total: {{ $feedbacks->total() }} feedback</p>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <th class="text-left py-4 px-6 font-bold text-gray-900">Pelanggan</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Kamar</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Rating</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Komentar</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Tanggal</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($feedbacks as $feedback)
            <tr class="hover:bg-blue-50 transition-colors duration-150">
              <td class="py-4 px-6">
              <div class="font-semibold text-gray-900">{{ $feedback->transaction->guest_name }}</div>
              <div class="text-sm text-gray-500">{{ $feedback->transaction->nik }}</div>
            </td>
            <td class="py-4 px-6">
              <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                {{ $feedback->transaction->room->room_number }}
              </span>
            </td>
            <td class="py-4 px-6">
              <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-900">{{ $feedback->rating }}</span>
                <div class="flex">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-sm {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-slate-300' }}"></i>
                  @endfor
                </div>
              </div>
            </td>
            <td class="py-4 px-6">
              <p class="text-gray-700 text-sm">{{ $feedback->comment ?? '-' }}</p>
            </td>
            <td class="py-4 px-6 text-gray-700">
              {{ $feedback->created_at->format('d M Y') }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-16 text-center text-slate-500">
              <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
              <p class="text-lg font-medium">Tidak ada feedback</p>
              <p class="text-sm text-slate-400 mt-1">Belum ada feedback dari pelanggan</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

  <!-- Pagination -->
  @if($feedbacks->hasPages())
    <div class="mt-6">
      {{ $feedbacks->links() }}
    </div>
  @endif
</div>
@endsection
