@extends('layouts.app')

@section('content')
<div>
  <h1 class="text-3xl font-bold mb-6"><i class="fas fa-star mr-2 text-yellow-500"></i>Rating & Feedback Pelanggan</h1>

  <!-- Stats -->
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Total Review</div>
      <div class="text-3xl font-bold">{{ $totalReviews }}</div>
    </div>
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Rating Rata-rata</div>
      <div class="text-3xl font-bold">{{ round($avgRating, 1) }}/5 <span class="text-lg">★</span></div>
    </div>
    <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg">
      <div class="text-sm opacity-80">Tingkat Kepuasan</div>
      <div class="text-3xl font-bold">{{ $totalReviews > 0 ? round((\Illuminate\Support\Collection::make($feedbacks)->where('rating', '>=', 4)->count() / $totalReviews) * 100) : 0 }}%</div>
    </div>
  </div>

  <!-- Feedback List -->
  <div class="space-y-4">
    @forelse($feedbacks as $fb)
      <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-400">
        <div class="flex justify-between items-start mb-2">
          <div>
            <h3 class="font-bold text-lg">{{ $fb->transaction->guest_name }} - Kamar {{ $fb->transaction->room->room_number }}</h3>
            <p class="text-sm text-gray-500">{{ $fb->created_at->format('d M Y H:i') }}</p>
          </div>
          <div class="text-yellow-500 text-2xl">{{ str_repeat('★', $fb->rating) }}{{ str_repeat('☆', 5 - $fb->rating) }}</div>
        </div>
        @if($fb->comment)
          <p class="text-gray-700 italic">{{ $fb->comment }}</p>
        @endif
      </div>
    @empty
      <div class="bg-gray-100 p-6 rounded-lg text-center text-gray-500">
        <i class="fas fa-inbox text-3xl mb-2"></i>
        <p>Belum ada feedback dari pelanggan.</p>
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $feedbacks->links() }}
  </div>
</div>
@endsection
