@extends('layouts.app')

@section('title', 'Buku Tamu Digital - Hotel Nuansa')
@section('page_title', 'Buku Tamu Digital')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <a href="{{ route('front-office') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-[#0B192C] transition-all mb-2">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Front Office</span>
      </a>
      <h2 class="text-xl md:text-2xl font-extrabold text-[#0B192C]">Buku Tamu Digital</h2>
      <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">
        Invoice: <strong>{{ $transaction->invoice_code }}</strong> | Kamar <strong>{{ $transaction->room->room_number }}</strong>
      </p>
    </div>

    @if(!$transaction->is_guest_data_complete)
      <span class="bg-amber-100 text-amber-800 border border-amber-300 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5 animate-pulse">
        <i class="fas fa-exclamation-triangle text-amber-500"></i>
        <span>Data Belum Lengkap</span>
      </span>
    @else
      <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5">
        <i class="fas fa-check-circle text-emerald-600"></i>
        <span>✓ Data Lengkap</span>
      </span>
    @endif
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
    <form method="POST" action="{{ route('transactions.updateGuestData', $transaction->id) }}" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Guest Name (Editable) -->
        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Tamu <span class="text-rose-500">*</span></label>
          <input type="text" name="guest_name" required value="{{ old('guest_name', $transaction->guest_name) }}"
                 placeholder="Masukkan nama lengkap tamu..."
                 class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm font-bold text-[#0B192C] focus:outline-none focus:ring-2 focus:ring-amber-400">
          <p class="text-[11px] text-slate-400 mt-1">Ubah nama default Express (misal: "GUEST ROOM 101") menjadi nama asli tamu sesuai KTP/SIM.</p>
        </div>

        <!-- NIK -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">NIK / No. Identitas <span class="text-rose-500">*</span></label>
          <input type="text" name="guest_nik" required value="{{ old('guest_nik', $transaction->guest_nik) }}"
                 placeholder="16 digit NIK KTP..."
                 class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
          @error('guest_nik')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
        </div>

        <!-- No HP -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">No. Handphone / WhatsApp <span class="text-rose-500">*</span></label>
          <input type="text" name="guest_phone" required value="{{ old('guest_phone', $transaction->guest_phone) }}"
                 placeholder="Contoh: 08123456789..."
                 class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
          @error('guest_phone')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
        </div>

        <!-- Jaminan Identitas -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Jaminan <span class="text-rose-500">*</span></label>
          <select name="guarantee_type" required
                  class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="KTP" {{ old('guarantee_type', $transaction->guarantee_type) === 'KTP' ? 'selected' : '' }}>KTP (Kartu Tanda Penduduk)</option>
            <option value="SIM" {{ old('guarantee_type', $transaction->guarantee_type) === 'SIM' ? 'selected' : '' }}>SIM (Surat Izin Mengemudi)</option>
            <option value="STNK" {{ old('guarantee_type', $transaction->guarantee_type) === 'STNK' ? 'selected' : '' }}>STNK Kendaraan</option>
          </select>
        </div>

        <!-- Status Jaminan Ditahan -->
        <div class="flex items-center pt-6">
          <label class="flex items-center gap-2.5 text-xs text-slate-700 font-bold cursor-pointer">
            <input type="checkbox" name="is_ktp_held" value="1" 
                   {{ $transaction->is_ktp_held ? 'checked' : '' }}
                   class="rounded text-[#F5A623] focus:ring-amber-400">
            <span>Fisik Jaminan Ditahan di Resepsionis</span>
          </label>
        </div>

        <!-- Alamat -->
        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-rose-500">*</span></label>
          <textarea name="guest_address" required rows="3"
                    placeholder="Alamat asal tamu sesuai identitas..."
                    class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">{{ old('guest_address', $transaction->guest_address) }}</textarea>
          @error('guest_address')<span class="block mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</span>@enderror
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center gap-3 pt-4 border-t border-stone-100">
        <a href="{{ route('front-office') }}" 
           class="px-6 py-2.5 rounded-full border border-stone-300 bg-white hover:bg-stone-50 text-slate-700 font-bold text-xs shadow-xs transition-all">
          Batal
        </a>
        <button type="submit" 
                class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-7 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
          Simpan Buku Tamu
        </button>
      </div>
    </form>
  </div>

</div>
@endsection
