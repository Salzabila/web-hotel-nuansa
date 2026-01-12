@extends('layouts.app')

@section('content')
<div class="w-full">
  <div class="bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-2"><i class="fas fa-star mr-2 text-yellow-500"></i>Berikan Rating</h1>
    <p class="text-gray-600 mb-6">Kami ingin mendengar pengalaman Anda menginap di Hotel Nuansa</p>

    <div class="mb-6 p-4 bg-blue-50 rounded border-l-4 border-blue-500">
      <p class="text-sm"><strong>Tamu:</strong> {{ $transaction->guest_name }}</p>
      <p class="text-sm"><strong>Kamar:</strong> {{ $transaction->room->room_number }} ({{ $transaction->room->type }})</p>
      <p class="text-sm"><strong>Tanggal:</strong> {{ $transaction->check_in->format('d/m/Y') }} - {{ $transaction->check_out->format('d/m/Y') }}</p>
    </div>

    <form method="POST" action="{{ route('feedbacks.store', $transaction->id) }}">
      @csrf
      
      <div class="mb-6">
        <label class="block text-lg font-semibold mb-4">Berapa rating untuk pengalaman Anda?</label>
        <div class="flex gap-4 justify-center">
          @for($i = 1; $i <= 5; $i++)
            <label class="cursor-pointer group">
              <input type="radio" name="rating" value="{{ $i }}" required class="hidden peer">
              <span class="text-4xl transition group-hover:scale-125" id="star-{{ $i }}">☆</span>
              <style>
                input[value="{{ $i }}"]:checked ~ span,
                input[value="{{ $i }}"]:hover ~ span,
                input[value="{{ $i }}"] ~ span:hover,
                input[value='{{ $i }}'] ~ span {
                  @for($j = 1; $j <= $i; $j++)
                    #star-{{ $j }} { content: '★'; }
                  @endfor
                }
              </style>
            </label>
          @endfor
        </div>
        <!-- Better star rating with JS -->
        <div class="flex gap-4 justify-center">
          @for($i = 1; $i <= 5; $i++)
            <button type="button" class="star-btn text-4xl cursor-pointer transition hover:scale-125" data-rating="{{ $i }}">☆</button>
          @endfor
        </div>
        <input type="hidden" name="rating" id="rating-input" value="">
      </div>

      <div class="mb-6">
        <label class="block text-lg font-semibold mb-2">Komentar (Opsional)</label>
        <textarea name="comment" rows="4" placeholder="Bagikan pengalaman Anda..." class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <div class="flex gap-3">
        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
          <i class="fas fa-paper-plane mr-2"></i>Kirim Rating
        </button>
        <a href="{{ route('dashboard') }}" class="flex-1 bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition text-center shadow-lg">
          Lewati
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const rating = btn.dataset.rating;
      document.getElementById('rating-input').value = rating;
      document.querySelectorAll('.star-btn').forEach((b, idx) => {
        b.textContent = idx < rating ? '★' : '☆';
        b.style.color = idx < rating ? '#f59e0b' : '#d1d5db';
      });
    });
    btn.addEventListener('mouseenter', () => {
      const rating = btn.dataset.rating;
      document.querySelectorAll('.star-btn').forEach((b, idx) => {
        b.style.color = idx < rating ? '#f59e0b' : '#d1d5db';
      });
    });
  });
  document.querySelector('.flex.gap-4').addEventListener('mouseleave', () => {
    const current = document.getElementById('rating-input').value;
    document.querySelectorAll('.star-btn').forEach((b, idx) => {
      b.style.color = idx < current ? '#f59e0b' : '#d1d5db';
    });
  });
</script>
@endsection
