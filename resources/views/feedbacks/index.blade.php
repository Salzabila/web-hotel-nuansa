@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-800">Feedback Tamu</h1>
      <p class="text-slate-500 mt-2 text-base">Daftar feedback dari tamu hotel</p>
    </div>
  </div>

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
  <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-slate-100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-slate-200">
          <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Tamu</th>
          <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Kamar</th>
          <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Rating</th>
          <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Komentar</th>
          <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider bg-transparent">Tanggal</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($feedbacks as $feedback)
          <tr class="hover:bg-slate-50 transition-colors duration-150">
            <td class="px-6 py-4">
              <div class="font-semibold text-slate-800">{{ $feedback->transaction->guest_name }}</div>
              <div class="text-sm text-slate-500">{{ $feedback->transaction->nik }}</div>
            </td>
            <td class="px-6 py-4">
              <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                {{ $feedback->transaction->room->room_number }}
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-slate-800">{{ $feedback->rating }}</span>
                <div class="flex">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-sm {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-slate-300' }}"></i>
                  @endfor
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <p class="text-slate-700 text-sm">{{ $feedback->comment ?? '-' }}</p>
            </td>
            <td class="px-6 py-4 text-slate-600 text-sm">
              {{ $feedback->created_at->format('d M Y') }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-16 text-center text-slate-500">
              <i class="fas fa-inbox text-6xl text-slate-300 mb-4 block"></i>
              <p class="text-lg font-medium">Belum ada feedback</p>
              <p class="text-sm text-slate-400">Feedback dari tamu akan muncul di sini</p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($feedbacks->hasPages())
    <div class="mt-6">
      {{ $feedbacks->links() }}
    </div>
  @endif
</div>
@endsection
