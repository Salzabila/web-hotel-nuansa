@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Back Button -->
  <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-lg mb-4 transition border-2 border-slate-300">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Dashboard</span>
  </a>

  <!-- Success Alert -->
  @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-md flex items-center gap-3">
      <i class="fas fa-check-circle text-2xl"></i>
      <p class="font-semibold">{{ session('success') }}</p>
    </div>
  @endif

  <!-- Form Section (shown by default) -->
  <div id="formSection">
    <!-- Header -->
    <div class="mb-6 text-center">
      <h1 class="text-3xl font-bold text-slate-800 mb-2">Lengkapi Data Check-in</h1>
      <p class="text-slate-500">Invoice: <span class="font-bold text-blue-600">{{ $transaction->invoice_code }}</span></p>
    </div>

    <form method="POST" action="{{ route('transactions.updateCheckInData', $transaction->id) }}" id="checkInDataForm">
      @csrf
      @method('PUT')

      <!-- Form Kasir & Shift -->
      <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border-2 border-slate-200 mb-6">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
          <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-user-tie text-blue-600 text-xl"></i>
          </div>
          <div>
            <h2 class="text-xl font-bold text-slate-800">Data Check-in</h2>
            <p class="text-sm text-slate-500">Isi sebelum cetak struk</p>
          </div>
        </div>

        <div class="space-y-5">
          <!-- Cashier Selection -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fas fa-user-tie text-blue-600 mr-1"></i>
              Kasir Bertugas 
              <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded ml-1">WAJIB</span>
            </label>
            <select 
              name="cashier_name" 
              class="w-full px-4 py-3 border-3 border-yellow-400 bg-yellow-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white text-base font-medium"
              required>
              <option value="">-- Pilih Nama Kasir --</option>
              @php
                $cashiers = \App\Models\User::orderBy('name')->get(['id', 'name']);
              @endphp
              @foreach($cashiers as $cashier)
                <option value="{{ $cashier->name }}">{{ $cashier->name }}</option>
              @endforeach
            </select>
            <p class="text-xs text-blue-600 mt-2 font-semibold">
              <i class="fas fa-exclamation-circle mr-1"></i>Pilih kasir yang melakukan check-in ini
            </p>
          </div>

          <!-- Shift Selection -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fas fa-clock text-purple-600 mr-1"></i>
              Shift Kerja 
              <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded ml-1">WAJIB</span>
            </label>
            <select 
              name="shift" 
              class="w-full px-4 py-3 border-3 border-yellow-400 bg-yellow-50 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white text-base font-medium"
              required>
              @php
                $hour = now()->hour;
                $currentShift = ($hour >= 7 && $hour < 19) ? 'Pagi' : 'Malam';
              @endphp
              <option value="Pagi" {{ $currentShift === 'Pagi' ? 'selected' : '' }}>☀️ Pagi (07:00 - 19:00)</option>
              <option value="Malam" {{ $currentShift === 'Malam' ? 'selected' : '' }}>🌙 Malam (19:00 - 07:00)</option>
            </select>
            <p class="text-xs text-purple-600 mt-2 font-semibold">
              <i class="fas fa-info-circle mr-1"></i>Otomatis terdeteksi: <strong>{{ $currentShift }}</strong> - Ubah jika perlu
            </p>
          </div>
        </div>

        <!-- Action Button -->
        <div class="mt-8 pt-6 border-t border-slate-200">
          <button 
            type="submit"
            style="background: #059669 !important; color: #ffffff !important;"
            class="w-full font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3 border-2"
            onmouseover="this.style.background='#047857 !important'"
            onmouseout="this.style.background='#059669 !important'">
            <i class="fas fa-arrow-right text-xl" style="color: #ffffff !important;"></i>
            <span class="text-lg" style="color: #ffffff !important;">Lanjut ke Cetak Struk</span>
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Print Preview (Hidden until data complete) -->
  <div id="printPreview" class="hidden">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden border-2 border-slate-300">
      <!-- Print Area -->
      <div id="print-struk" class="receipt-container" style="width: 80mm; margin: 0 auto; padding: 10mm; font-family: 'Courier New', monospace; font-size: 11pt; background: white;">
        <div style="text-align: center; border-bottom: 2px dashed #333; padding-bottom: 8px; margin-bottom: 8px;">
          <div style="font-size: 18pt; font-weight: bold; margin-bottom: 4px;">HOTEL NUANSA</div>
          <div style="font-size: 9pt;">Jl. Raya Hotel No. 123</div>
          <div style="font-size: 9pt; margin-bottom: 4px;">Telp: (0274) 123456</div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="display: flex; justify-content: space-between; font-size: 10pt;">
            <span>INVOICE</span>
            <span style="font-weight: bold;">{{ $transaction->invoice_code }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Tanggal</span>
            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Shift</span>
            <span id="printShift">-</span>
          </div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="font-size: 10pt; font-weight: bold; margin-bottom: 3px;">TAMU</div>
          <div style="font-size: 10pt;">{{ $transaction->guest_name }}</div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="font-size: 10pt; font-weight: bold; margin-bottom: 3px;">KAMAR</div>
          <div style="display: flex; justify-content: space-between; font-size: 10pt;">
            <span>Nomor</span>
            <span style="font-weight: bold;">{{ $transaction->room->room_number }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Tipe</span>
            <span>{{ ucfirst($transaction->room->room_type) }}</span>
          </div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Check-in</span>
            <span>{{ $transaction->check_in ? $transaction->check_in->format('d/m/Y H:i') : '-' }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Check-out</span>
            <span>{{ $transaction->check_out ? $transaction->check_out->format('d/m/Y H:i') : '-' }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 10pt; font-weight: bold; margin-top: 3px;">
            <span>Durasi</span>
            <span>{{ $transaction->duration }} Hari</span>
          </div>
        </div>

        <div style="border-bottom: 2px solid #333; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="display: flex; justify-content: space-between; font-size: 10pt;">
            <span>Metode Bayar</span>
            <span style="font-weight: bold;">{{ strtoupper($transaction->payment_method) }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 10pt; margin-top: 3px;">
            <span>Harga/Malam</span>
            <span>Rp {{ number_format($transaction->total_price / $transaction->duration, 0, ',', '.') }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 10pt;">
            <span>{{ $transaction->duration }} Malam</span>
            <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 12pt; font-weight: bold; margin-top: 6px; background: #f0f0f0; padding: 4px;">
            <span>TOTAL</span>
            <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
          </div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="text-align: center; font-size: 11pt; font-weight: bold; margin-bottom: 3px;">STATUS PEMBAYARAN</div>
          <div style="text-align: center; font-size: 14pt; font-weight: bold; background: #fef3c7; padding: 4px; border: 2px solid #fbbf24;">BELUM DIBAYAR</div>
        </div>

        <div style="border-bottom: 1px dashed #666; padding-bottom: 6px; margin-bottom: 6px;">
          <div style="display: flex; justify-content: space-between; font-size: 9pt;">
            <span>Kasir</span>
            <span style="font-weight: bold;" id="printCashier">-</span>
          </div>
        </div>

        <div style="text-align: center; font-size: 8pt; padding-top: 8px;">
          <div>Terima kasih atas kunjungan Anda</div>
          <div style="margin-top: 4px;">CS: 0812-3456-7890</div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div style="padding: 20px; background: #f8fafc; border-top: 2px solid #e2e8f0;">
        <div class="flex gap-3 justify-center">
          <button 
            onclick="window.print()" 
            style="background: #4f46e5 !important; color: #ffffff !important;"
            class="font-bold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center gap-2 border-2"
            onmouseover="this.style.background='#4338ca !important'"
            onmouseout="this.style.background='#4f46e5 !important'">
            <i class="fas fa-print" style="color: #ffffff !important;"></i>
            <span style="color: #ffffff !important;">Cetak Struk</span>
          </button>

          @if(!$transaction->is_guest_data_complete)
            <a 
              href="{{ route('transactions.guestBook', $transaction->id) }}"
              style="background: #f97316 !important; color: #ffffff !important;"
              class="font-bold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center gap-2 border-2 animate-pulse"
              onmouseover="this.style.background='#ea580c !important'; this.classList.remove('animate-pulse')"
              onmouseout="this.style.background='#f97316 !important'; this.classList.add('animate-pulse')">
              <i class="fas fa-book-open" style="color: #ffffff !important;"></i>
              <span style="color: #ffffff !important;">Isi Buku Tamu Sekarang</span>
            </a>
          @endif

          <a 
            href="{{ route('dashboard') }}"
            style="background: #059669 !important; color: #ffffff !important;"
            class="font-bold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center gap-2 border-2"
            onmouseover="this.style.background='#047857 !important'"
            onmouseout="this.style.background='#059669 !important'">
            <i class="fas fa-home" style="color: #ffffff !important;"></i>
            <span style="color: #ffffff !important;">Ke Beranda</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
@media print {
  body * { visibility: hidden; }
  #print-struk, #print-struk * { visibility: visible; }
  #print-struk { position: absolute; left: 0; top: 0; width: 80mm !important; }
}

button[onclick="window.print()"] {
  background-color: #4f46e5 !important;
  color: white !important;
}
</style>

<script>
// Show print preview after form submission
document.getElementById('checkInDataForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const cashierName = document.querySelector('select[name="cashier_name"]').value;
  const shift = document.querySelector('select[name="shift"]').value;
  
  if (!cashierName || !shift) {
    alert('Harap isi semua data yang diperlukan!');
    return;
  }
  
  // Update print preview
  document.getElementById('printCashier').textContent = cashierName;
  document.getElementById('printShift').textContent = shift;
  
  // Submit form via AJAX to save data
  const formData = new FormData(this);
  
  fetch(this.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    // Hide form, show print preview
    document.getElementById('formSection').style.display = 'none';
    document.getElementById('printPreview').classList.remove('hidden');
    
    // Auto-scroll to preview
    document.getElementById('printPreview').scrollIntoView({ behavior: 'smooth', block: 'start' });
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan. Silakan coba lagi.');
  });
});
</script>
@endsection
