@extends('layouts.app')

@section('content')
<div class="h-full">
  <!-- Header -->
  <div class="mb-8">
    <a href="{{ route('transactions.receipt', $transaction->id) }}" class="inline-flex items-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-lg mb-3 transition border-2 border-slate-300">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Struk</span>
    </a>
    <div class="flex items-center gap-4">
      <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
        <i class="fas fa-book text-white text-2xl"></i>
      </div>
      <div>
        <h1 class="text-3xl font-bold text-slate-800">Buku Tamu Digital</h1>
        <p class="text-slate-500 mt-1">
          Invoice: <span class="font-bold text-blue-600">{{ $transaction->invoice_code }}</span> 
          | Kamar <span class="font-bold">{{ $transaction->room->room_number }}</span>
        </p>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-md flex items-center gap-3">
      <i class="fas fa-check-circle text-2xl"></i>
      <p class="font-semibold">{{ session('success') }}</p>
    </div>
  @endif

  @if(!$transaction->is_guest_data_complete)
    <!-- Warning Banner -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-2xl p-6 mb-6 shadow-lg">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
          <i class="fas fa-exclamation-triangle text-3xl"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold mb-1">Data Tamu Belum Lengkap</h2>
          <p class="text-orange-50 text-sm">Silakan lengkapi data identitas tamu untuk keperluan administrasi hotel</p>
        </div>
      </div>
    </div>
  @endif

  <!-- Guest Book Form -->
  <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-slate-200">
    <form method="POST" action="{{ route('transactions.updateGuestData', $transaction->id) }}">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-5">
          <!-- Guest Name (AUTO-FILLED) -->
          <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-4">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              <i class="fas fa-user text-blue-600 mr-2"></i>Nama Tamu
            </label>
            <p class="text-xl font-bold text-slate-800">{{ $transaction->guest_name }}</p>
            <p class="text-xs text-slate-500 mt-1">Nama saat check-in (tidak bisa diubah)</p>
          </div>

          <!-- NIK -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              NIK / No. KTP <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              name="guest_nik" 
              value="{{ old('guest_nik', $transaction->guest_nik) }}" 
              class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 {{ $errors->has('guest_nik') ? 'border-red-500' : '' }}" 
              placeholder="16 digit NIK"
              maxlength="16"
              pattern="[0-9]{16}"
              {{ $transaction->is_guest_data_complete ? 'readonly' : 'required' }}
              {{ $transaction->is_guest_data_complete ? 'class=bg-slate-100' : '' }}>
            @error('guest_nik')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
            @if($transaction->guest_nik)
              <p class="text-xs text-emerald-600 mt-1.5">
                <i class="fas fa-check-circle mr-1"></i>Data sudah tersimpan
              </p>
            @endif
          </div>

          <!-- Phone -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              No. Telepon / HP <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              name="guest_phone" 
              value="{{ old('guest_phone', $transaction->guest_phone) }}" 
              class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 {{ $errors->has('guest_phone') ? 'border-red-500' : '' }}" 
              placeholder="Contoh: 081234567890"
              {{ $transaction->is_guest_data_complete ? 'readonly' : 'required' }}
              {{ $transaction->is_guest_data_complete ? 'class=bg-slate-100' : '' }}>
            @error('guest_phone')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
            @if($transaction->guest_phone)
              <p class="text-xs text-emerald-600 mt-1.5">
                <i class="fas fa-check-circle mr-1"></i>Data sudah tersimpan
              </p>
            @endif
          </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-5">
          <!-- Address -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea 
              name="guest_address" 
              class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 {{ $errors->has('guest_address') ? 'border-red-500' : '' }}" 
              rows="4" 
              placeholder="Alamat lengkap sesuai KTP"
              {{ $transaction->is_guest_data_complete ? 'readonly' : 'required' }}
              {{ $transaction->is_guest_data_complete ? 'class=bg-slate-100' : '' }}>{{ old('guest_address', $transaction->guest_address) }}</textarea>
            @error('guest_address')
              <span class="block mt-1.5 text-sm text-red-600">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
              </span>
            @enderror
            @if($transaction->guest_address)
              <p class="text-xs text-emerald-600 mt-1.5">
                <i class="fas fa-check-circle mr-1"></i>Data sudah tersimpan
              </p>
            @endif
          </div>

          <!-- Guarantee Type -->
          <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-4">
              <i class="fas fa-shield-alt text-amber-600"></i>
              <span class="font-bold text-slate-800">Jaminan Identitas <span class="text-red-500">*</span></span>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Jenis Jaminan <span class="text-red-500">*</span>
              </label>
              <select 
                name="guarantee_type" 
                id="guarantee_type" 
                class="w-full px-4 py-3 border-2 border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-slate-800 font-semibold bg-white {{ $errors->has('guarantee_type') ? 'border-red-500' : '' }}"
                {{ $transaction->is_guest_data_complete && $transaction->guarantee_type ? 'disabled' : 'required' }}>
                <option value="">-- Pilih Jenis Jaminan --</option>
                <option value="KTP" {{ old('guarantee_type', $transaction->guarantee_type) == 'KTP' ? 'selected' : '' }}>KTP (Kartu Tanda Penduduk)</option>
                <option value="SIM" {{ old('guarantee_type', $transaction->guarantee_type) == 'SIM' ? 'selected' : '' }}>SIM (Surat Izin Mengemudi)</option>
                <option value="STNK" {{ old('guarantee_type', $transaction->guarantee_type) == 'STNK' ? 'selected' : '' }}>STNK (Surat Tanda Nomor Kendaraan)</option>
              </select>
              @if($transaction->is_guest_data_complete && $transaction->guarantee_type)
                <!-- Hidden input when disabled -->
                <input type="hidden" name="guarantee_type" value="{{ $transaction->guarantee_type }}">
              @endif
              @error('guarantee_type')
                <span class="block mt-1.5 text-sm text-red-600">
                  <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </span>
              @enderror
              @if($transaction->guarantee_type)
                <p class="text-xs text-emerald-600 mt-2">
                  <i class="fas fa-check-circle mr-1"></i>Jaminan sudah tercatat
                </p>
              @endif
            </div>

            <!-- Checkbox KTP Held -->
            <div class="mt-4 flex items-center gap-2">
              <input 
                type="checkbox" 
                name="is_ktp_held" 
                id="is_ktp_held" 
                value="1"
                {{ old('is_ktp_held', $transaction->is_ktp_held) ? 'checked' : '' }}
                {{ $transaction->is_guest_data_complete ? 'disabled' : '' }}
                class="w-5 h-5 text-amber-600 border-2 border-amber-300 rounded focus:ring-amber-500">
              <label for="is_ktp_held" class="text-sm font-medium text-slate-700">
                Jaminan sudah diserahkan ke resepsionis
              </label>
              @if($transaction->is_guest_data_complete && $transaction->is_ktp_held)
                <input type="hidden" name="is_ktp_held" value="1">
              @endif
            </div>
          </div>

          <!-- Info Box -->
          <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
              <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5"></i>
              <div class="text-sm text-blue-800 leading-relaxed">
                <p class="font-semibold mb-1">Informasi Penting:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                  <li>Data ini untuk keperluan administrasi hotel</li>
                  <li>Pastikan data sesuai dengan kartu identitas</li>
                  <li>Jaminan akan dikembalikan saat check-out</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="mt-8 flex gap-4">
        @if(!$transaction->is_guest_data_complete)
          <button 
            type="submit" 
            class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
            <i class="fas fa-save text-xl"></i>
            <span class="text-lg">Simpan Data Tamu</span>
          </button>
        @endif
        <a 
          href="{{ route('transactions.receipt', $transaction->id) }}" 
          class="{{ !$transaction->is_guest_data_complete ? 'px-8' : 'flex-1' }} bg-gray-700 hover:bg-gray-800 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3 border-2 border-gray-800">
          <i class="fas fa-arrow-left text-xl"></i>
          <span class="text-lg">Kembali</span>
        </a>
      </div>
    </form>
  </div>

  <!-- Data Complete Status -->
  @if($transaction->is_guest_data_complete)
    <div class="mt-6 bg-emerald-100 border-2 border-emerald-300 rounded-xl p-5 text-center">
      <i class="fas fa-check-circle text-emerald-600 text-3xl mb-2"></i>
      <p class="font-bold text-emerald-800 text-lg">Data Tamu Sudah Lengkap</p>
      <p class="text-emerald-700 text-sm mt-1">Semua data identitas tamu telah tersimpan</p>
    </div>
  @endif
</div>
@endsection
