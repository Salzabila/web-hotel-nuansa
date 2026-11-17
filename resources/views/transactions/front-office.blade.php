@extends('layouts.app')

@section('title', 'Front Office - Hotel Nuansa')
@section('page_title', 'Front Office')

@section('content')
<div class="space-y-6">

  <!-- TOP SUMMARY BANNER: MY RECAP -->
  <div class="bg-[#1D58B8] text-white rounded-3xl p-6 md:p-8 shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <p class="text-blue-100 text-xs font-bold tracking-wide">
        My Recap · {{ $currentShift === 'Malam' ? 'Shift Malam' : 'Shift Pagi' }}
      </p>
      <h3 class="text-3xl md:text-4xl font-black tracking-tight mt-1 mb-1">
        Rp {{ number_format($myTodayCashIn ?? 0, 0, ',', '.') }}
      </h3>
      <p class="text-blue-200 text-xs font-medium">
        Tunai masuk dari transaksi Anda hari ini
      </p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('recaps.personal') }}" 
         class="bg-white/15 hover:bg-white/25 border border-white/20 text-white font-bold text-xs px-5 py-2.5 rounded-full transition-all flex items-center gap-2 self-start md:self-auto">
        <i class="fas fa-receipt"></i>
        <span>Detail Shift Saya</span>
      </a>
    </div>
  </div>

  <!-- WARNING BANNER: INCOMPLETE GUEST DATA -->
  @if(($incompleteGuestsCount ?? 0) > 0)
    <div class="bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-amber-500/5 border-2 border-amber-400 rounded-3xl p-5 md:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-start sm:items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-[#F5A623] text-[#0B192C] flex items-center justify-center shrink-0 shadow-md">
          <i class="fas fa-exclamation-triangle text-xl animate-pulse"></i>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h4 class="text-sm md:text-base font-extrabold text-[#0B192C]">
              Perhatian: Ada {{ $incompleteGuestsCount }} Tamu Belum Melengkapi Data Identitas!
            </h4>
            <span class="bg-rose-500 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Segera Isi
            </span>
          </div>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            Tamu hasil Express Check-in belum memiliki NIK, nomor HP, atau alamat. Harap segera lengkapi di Buku Tamu Digital sebelum waktu checkout.
          </p>
        </div>
      </div>
      <a href="#buku-tamu-section" 
         class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold text-xs px-6 py-3 rounded-full shadow-md transition-all active:scale-95 whitespace-nowrap self-start md:self-auto flex items-center gap-2">
        <i class="fas fa-user-edit"></i>
        <span>Lihat & Lengkapi Data</span>
      </a>
    </div>
  @endif

  <!-- WARNING BANNER: APPROACHING / OVERDUE CHECKOUT -->
  @if(($approachingCheckoutCount ?? 0) > 0)
    <div class="bg-gradient-to-r from-rose-500/15 via-amber-500/10 to-transparent border-2 border-rose-400 rounded-3xl p-5 md:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div class="flex items-start sm:items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-md">
          <i class="fas fa-bell text-xl animate-bounce"></i>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h4 class="text-sm md:text-base font-extrabold text-[#0B192C]">
              Peringatan Checkout: Ada {{ $approachingCheckoutCount }} Kamar Mendekati / Melewati Batas Checkout!
            </h4>
            <span class="bg-rose-600 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Batas 12:00
            </span>
          </div>
          <p class="text-xs text-slate-600 mt-1 leading-relaxed">
            @php
              $overdueList = $approachingCheckoutGuests->filter(fn($g) => $g->checkout_urgency === 'overdue');
              $imminentList = $approachingCheckoutGuests->filter(fn($g) => $g->checkout_urgency === 'imminent');
            @endphp
            @if($overdueList->isNotEmpty())
              <strong class="text-rose-600">{{ $overdueList->count() }} kamar sudah lewat batas jam 12:00:</strong> Kamar {{ $overdueList->map(fn($g) => $g->room->room_number)->join(', ') }}.
            @endif
            @if($imminentList->isNotEmpty())
              <span class="text-amber-800 font-semibold">{{ $imminentList->count() }} kamar sisa waktu < 2 jam: Kamar {{ $imminentList->map(fn($g) => $g->room->room_number)->join(', ') }}.</span>
            @endif
            Harap segera hubungi tamu untuk proses checkout atau perpanjangan durasi (extend stay).
          </p>
        </div>
      </div>
      @if($approachingCheckoutGuests->isNotEmpty())
        <a href="{{ route('checkin', ['tx_id' => $approachingCheckoutGuests->first()->id]) }}" 
           class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs px-5 py-2.5 rounded-full shadow-md transition-all active:scale-95 flex items-center gap-2 whitespace-nowrap self-start md:self-auto shrink-0">
          <i class="fas fa-arrow-right-from-bracket"></i>
          <span>Checkout Kamar {{ $approachingCheckoutGuests->first()->room->room_number }}</span>
        </a>
      @endif
    </div>
  @endif

  <!-- MAIN 2-COLUMN GRID: CHECK-IN (LEFT) & CHECKOUT (RIGHT) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- LEFT COLUMN: CHECK-IN STANDAR / EXPRESS & BUKU TAMU DIGITAL (Col 6) -->
    <div class="lg:col-span-6 space-y-6">
      
      <!-- CARD: CHECK-IN STANDAR / EXPRESS -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <h3 class="text-base md:text-lg font-bold text-[#0B192C] mb-6">Check-in Standar / Express</h3>

        @if($availableRooms->isEmpty())
          <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold text-center">
            <i class="fas fa-exclamation-circle text-lg mb-1 block"></i>
            Semua kamar saat ini sedang terisi atau dalam pembersihan.
          </div>
        @else
          <form id="frontOfficeCheckinForm" method="POST" action="{{ route('transactions.store', $selectedRoom ? $selectedRoom->id : $availableRooms->first()->id) }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              
              <!-- Kamar -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kamar</label>
                <select name="room_id" id="roomSelector" onchange="onRoomChanged()"
                        class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
                  @foreach($availableRooms as $r)
                    <option value="{{ $r->id }}" data-price="{{ $r->price_per_night }}" data-number="{{ $r->room_number }}"
                            {{ ($selectedRoom && $selectedRoom->id === $r->id) ? 'selected' : '' }}>
                      {{ $r->room_number }} - {{ $r->type }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Nama Tamu -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5" id="guestNameLabel">
                  Nama tamu (kosong = GUEST ROOM {{ $selectedRoom ? $selectedRoom->room_number : $availableRooms->first()->room_number }})
                </label>
                <input type="text" name="guest_name" id="guestNameInput"
                       placeholder="Nama tamu..."
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
              </div>

              <!-- Metode Pembayaran -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Metode pembayaran</label>
                <select name="payment_method_id"
                        class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm bg-white font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400">
                  @foreach($paymentMethods as $pm)
                    <option value="{{ $pm->id }}" class="text-slate-800 font-semibold py-1">
                      {{ $pm->bank_name ?: $pm->name }}@if(!empty($pm->account_number)) - {{ $pm->account_number }}@endif
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Durasi (malam) -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Durasi (malam)</label>
                <input type="number" name="duration" id="durationInput" value="1" min="1" oninput="calculateTotalBill()"
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
              </div>

              <!-- Jaminan Identitas -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jaminan identitas</label>
                <select name="guarantee_type"
                        class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
                  <option value="KTP">KTP</option>
                  <option value="SIM">SIM</option>
                  <option value="STNK">STNK</option>
                </select>
              </div>

              <!-- Komisi TC -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Komisi TC (Rp, opsional)</label>
                <input type="number" name="tc_nominal" id="tcNominalInput" value="0" min="0" oninput="toggleTC(this.value)"
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                <input type="hidden" name="is_tc" id="isTcInput" value="0">
              </div>

            </div>

            <!-- Checkboxes row -->
            <div class="flex flex-wrap items-center gap-6 mt-5 text-xs text-slate-700 font-semibold">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_ktp_held" value="1" checked class="rounded text-[#F5A623] focus:ring-amber-400">
                <span>Jaminan ditahan</span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="skip_print" id="skipPrintCheckbox" value="1" class="rounded text-[#F5A623] focus:ring-amber-400">
                <span>Lewati cetak struk</span>
              </label>
            </div>

            <!-- Total Tagihan & Action Buttons Box -->
            <div class="bg-[#F8F5EF] rounded-2xl p-4 md:p-5 mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div>
                <p class="text-xs text-slate-500 font-semibold">Total tagihan</p>
                <h4 class="text-2xl font-black text-[#0B192C]" id="totalBillDisplay">Rp 0</h4>
              </div>
              
              <div class="flex items-center gap-3">
                <!-- Express Check-in Button -->
                <button type="button" onclick="submitExpressCheckin()"
                        class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-5 py-2.5 rounded-full text-xs shadow-xs transition-all active:scale-95">
                  Express Check-in
                </button>
                
                <!-- Check-in & Cetak Button -->
                <button type="submit"
                        class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
                  Check-in & Cetak
                </button>
              </div>
            </div>

          </form>
        @endif

      </div>

      <!-- CARD: BUKU TAMU DIGITAL -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50" id="buku-tamu-section">
        <div class="flex items-start justify-between">
          <div>
            <h3 class="text-base font-bold text-[#0B192C] mb-1.5 flex items-center gap-2">
              <span>Buku Tamu Digital</span>
              @if(($incompleteGuestsCount ?? 0) > 0)
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
              @endif
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed max-w-md">
              Lengkapi NIK, telepon, alamat, dan jenis jaminan tamu Express Check-in.
            </p>
          </div>
          @if(($incompleteGuestsCount ?? 0) > 0)
            <span class="bg-rose-100 text-rose-700 border border-rose-200 font-extrabold text-[11px] px-3.5 py-1 rounded-full whitespace-nowrap">
              ⚠️ {{ $incompleteGuestsCount }} Perlu Dilengkapi
            </span>
          @else
            <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 font-extrabold text-[11px] px-3.5 py-1 rounded-full whitespace-nowrap">
              ✓ Semua Lengkap
            </span>
          @endif
        </div>

        @if(($incompleteGuestsCount ?? 0) > 0)
          <!-- List of Incomplete Guests with quick action buttons -->
          <div class="mt-5 space-y-2.5">
            <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
              <i class="fas fa-clipboard-list text-amber-500"></i>
              <span>Daftar Tamu Belum Lengkap:</span>
            </p>
            <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
              @foreach($incompleteGuests as $guest)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50/70 border border-amber-200/80 hover:bg-amber-100/60 transition-all">
                  <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-[#F5A623] text-[#0B192C] font-black text-xs flex items-center justify-center shrink-0 shadow-xs">
                      {{ $guest->room->room_number ?? '-' }}
                    </span>
                    <div>
                      <p class="text-xs font-bold text-[#0B192C]">{{ $guest->guest_name }}</p>
                      <p class="text-[11px] text-amber-900/80 font-medium">
                        Check-in: {{ \Carbon\Carbon::parse($guest->check_in)->format('d M H:i') }} · {{ $guest->duration }} Malam
                      </p>
                    </div>
                  </div>
                  <a href="{{ route('transactions.guestBook', $guest->id) }}" 
                     class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold text-[11px] px-3.5 py-1.5 rounded-full shadow-xs transition-all active:scale-95 flex items-center gap-1.5 shrink-0">
                    <i class="fas fa-pen-to-square"></i>
                    <span>Isi Data</span>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @else
          <div class="mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-600 text-base shrink-0"></i>
            <span>Semua data tamu menginap saat ini sudah lengkap terisi & terverifikasi.</span>
          </div>
        @endif

        <div class="mt-5 pt-4 border-t border-stone-100 flex items-center justify-between">
          <span class="text-[11px] text-slate-400 font-medium">Tertib administrasi & keamanan tamu</span>
          <a href="{{ route('transactions.index') }}" 
             class="text-xs font-bold text-slate-600 hover:text-[#0B192C] transition-all flex items-center gap-1">
            <span>Lihat Semua Transaksi</span>
            <i class="fas fa-chevron-right text-[10px]"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- RIGHT COLUMN: CHECKOUT CEPAT (Col 6) -->
    <div class="lg:col-span-6 space-y-6">
      
      <!-- CARD: CHECKOUT CEPAT -->
      <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-stone-200/50">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-base md:text-lg font-bold text-[#0B192C]">
            Checkout Cepat · Kamar <span id="coRoomNumberText">{{ $selectedTx ? $selectedTx->room->room_number : '-' }}</span>
          </h3>

          @if($activeTransactions->isNotEmpty())
            <!-- Room/Tx Selector if multiple -->
            <select id="activeTxSelector" onchange="onActiveTxChanged(this.value)"
                    class="text-xs font-bold text-slate-700 bg-stone-100 border border-stone-200 rounded-xl px-3 py-1.5 focus:outline-none">
              @foreach($activeTransactions as $tx)
                @php
                  $badgeText = '';
                  if ($tx->checkout_urgency === 'overdue') {
                    $badgeText = ' [🚨 Lewat CO]';
                  } elseif ($tx->checkout_urgency === 'imminent') {
                    $badgeText = ' [⏳ ' . $tx->checkout_countdown_text . ']';
                  } elseif ($tx->checkout_urgency === 'today') {
                    $badgeText = ' [CO Hari Ini]';
                  }
                @endphp
                <option value="{{ $tx->id }}" {{ ($selectedTx && $selectedTx->id === $tx->id) ? 'selected' : '' }}>
                  Kamar {{ $tx->room->room_number }} ({{ $tx->guest_name }}){{ $badgeText }}
                </option>
              @endforeach
            </select>
          @endif
        </div>

        @if(!$selectedTx)
          <div class="py-12 text-center text-slate-400">
            <i class="fas fa-bed text-4xl mb-3 opacity-30"></i>
            <p class="text-sm font-semibold">Tidak ada kamar yang sedang aktif untuk di-checkout.</p>
          </div>
        @else
          <!-- Warning if selected guest is approaching or overdue checkout -->
          @if($selectedTx->checkout_urgency === 'overdue')
            <div class="mb-5 p-4 rounded-2xl bg-rose-50 border-2 border-rose-500 text-rose-950 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
              <div class="flex items-start sm:items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                  <i class="fas fa-clock text-sm"></i>
                </div>
                <div>
                  <span class="font-extrabold text-xs block text-rose-900">
                    🚨 PERINGATAN: Melewati Batas Checkout ({{ $selectedTx->checkout_countdown_text }})!
                  </span>
                  <span class="text-rose-700 text-[11px] block mt-0.5">
                    Batas checkout adalah pukul {{ $selectedTx->check_out ? $selectedTx->check_out->format('d M, H:i') : '12:00' }} WIB. Harap segera proses checkout atau tawarkan perpanjangan sewa (Extend Stay).
                  </span>
                </div>
              </div>
              <button type="button" onclick="extendCurrentStay({{ $selectedTx->id }})" 
                      class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-[11px] px-3.5 py-2 rounded-full transition-all active:scale-95 whitespace-nowrap self-start sm:self-auto shrink-0 flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-calendar-plus"></i>
                <span>Extend Stay</span>
              </button>
            </div>
          @elseif($selectedTx->checkout_urgency === 'imminent')
            <div class="mb-5 p-4 rounded-2xl bg-amber-50 border-2 border-amber-400 text-amber-950 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
              <div class="flex items-start sm:items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-[#F5A623] text-[#0B192C] flex items-center justify-center shrink-0 shadow-xs">
                  <i class="fas fa-hourglass-half text-sm animate-pulse"></i>
                </div>
                <div>
                  <span class="font-extrabold text-xs block text-amber-900">
                    ⏳ PERINGATAN: Mendekati Waktu Checkout ({{ $selectedTx->checkout_countdown_text }})!
                  </span>
                  <span class="text-amber-800 text-[11px] block mt-0.5">
                    Batas waktu checkout kamar ini adalah pukul {{ $selectedTx->check_out ? $selectedTx->check_out->format('H:i') : '12:00' }} WIB hari ini.
                  </span>
                </div>
              </div>
              <button type="button" onclick="extendCurrentStay({{ $selectedTx->id }})" 
                      class="bg-[#0B192C] hover:bg-[#152e4d] text-white font-extrabold text-[11px] px-3.5 py-2 rounded-full transition-all active:scale-95 whitespace-nowrap self-start sm:self-auto shrink-0 flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-calendar-plus text-amber-400"></i>
                <span>Extend Stay</span>
              </button>
            </div>
          @elseif($selectedTx->checkout_urgency === 'today')
            <div class="mb-5 p-3.5 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 text-xs flex items-center gap-2.5">
              <i class="fas fa-info-circle text-blue-500 text-sm shrink-0"></i>
              <div>
                <span class="font-bold">Jadwal Checkout Hari Ini:</span>
                <span class="text-blue-700">Pukul {{ $selectedTx->check_out ? $selectedTx->check_out->format('H:i') : '12:00' }} WIB ({{ $selectedTx->checkout_countdown_text }}).</span>
              </div>
            </div>
          @endif

          <!-- Warning if selected guest data is incomplete -->
          @if(!$selectedTx->is_guest_data_complete)
            <div class="mb-5 p-4 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-900 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
              <div class="flex items-start sm:items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                  <i class="fas fa-exclamation-triangle text-sm"></i>
                </div>
                <div>
                  <span class="font-extrabold text-xs block text-rose-950">Data Tamu Kamar Ini Belum Lengkap!</span>
                  <span class="text-rose-700 text-[11px] block mt-0.5">Tamu masuk via Express Check-in dan belum memiliki NIK/identitas. Harap lengkapi sebelum checkout.</span>
                </div>
              </div>
              <a href="{{ route('transactions.guestBook', $selectedTx->id) }}" 
                 class="bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-[11px] px-3.5 py-2 rounded-full transition-all active:scale-95 whitespace-nowrap self-start sm:self-auto shrink-0 flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-pen-to-square"></i>
                <span>Lengkapi Sekarang</span>
              </a>
            </div>
          @endif

          <form id="frontOfficeCheckoutForm" method="POST" action="{{ route('transactions.processCheckout', $selectedTx->id) }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Biaya Tambahan Description -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Biaya tambahan</label>
                <input type="text" name="additional_charges_note" placeholder="Overtime / Minibar / Laundry"
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
              </div>

              <!-- Nominal (Rp) -->
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal (Rp)</label>
                <input type="number" name="additional_charges" id="coAdditionalInput" value="0" min="0" oninput="recalcCheckout()"
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
              </div>
            </div>

            <!-- Inner Summary Box -->
            <div class="bg-[#F8F5EF] rounded-2xl p-4 md:p-5 my-5 space-y-2 text-xs">
              <div class="flex justify-between text-slate-600">
                <span>Tagihan kamar:</span>
                <strong class="text-slate-800" id="coTagihanKamarText">
                  Rp {{ number_format($selectedTx->room->price_per_night * $selectedTx->duration, 0, ',', '.') }}
                </strong>
              </div>
              <div class="flex justify-between text-slate-600">
                <span>Biaya tambahan:</span>
                <strong class="text-slate-800" id="coBiayaTambahanText">Rp 0</strong>
              </div>
              <div class="flex justify-between items-center text-slate-600">
                <span>Metode Bayar Awal:</span>
                <span class="font-bold text-[#0B192C] bg-white border border-stone-200 px-2.5 py-0.5 rounded-lg text-xs flex items-center gap-1.5 shadow-2xs">
                  <i class="fas fa-wallet text-amber-500"></i>
                  <span id="coPaymentMethodText">{{ $selectedTx->paymentMethod->bank_name ?? $selectedTx->paymentMethod->name ?? 'Cash' }}</span>
                </span>
              </div>
              <div class="flex justify-between items-center pt-2 border-t border-stone-200">
                <span class="text-slate-700 font-bold">Status Pembayaran:</span>
                <span id="coStatusBadge">
                  @if($selectedTx->payment_status === 'paid')
                    <span class="bg-[#DCFCE7] text-[#16A34A] text-[11px] font-bold px-2.5 py-0.5 rounded-full">Paid</span>
                  @elseif($selectedTx->payment_status === 'partial')
                    <span class="bg-[#FEF3C7] text-[#D97706] text-[11px] font-bold px-2.5 py-0.5 rounded-full">Partial</span>
                  @else
                    <span class="bg-[#FEE2E2] text-[#DC2626] text-[11px] font-bold px-2.5 py-0.5 rounded-full">Unpaid</span>
                  @endif
                </span>
              </div>
            </div>

            <!-- Total Bayar & Metode Pembayaran Checkout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Bayar Saat Checkout (Rp)</label>
                <input type="number" name="paid_amount" id="coPaidAmountInput" required min="0"
                       value="{{ $selectedTx->room->price_per_night * $selectedTx->duration }}"
                       class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm font-extrabold text-[#0B192C] focus:outline-none focus:ring-2 focus:ring-amber-400">
              </div>

              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Metode Bayar Checkout</label>
                <select name="payment_method_id" id="coPaymentMethodSelect"
                        class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-xs md:text-sm bg-white font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400">
                  @foreach($paymentMethods as $pm)
                    <option value="{{ $pm->id }}" {{ $selectedTx->payment_method_id == $pm->id ? 'selected' : '' }} class="text-slate-800 font-semibold py-1">
                      {{ $pm->bank_name ?: $pm->name }}@if(!empty($pm->account_number)) - {{ $pm->account_number }}@endif
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Hidden required variables -->
            <input type="hidden" name="cashier_name" value="{{ auth()->user()->name }}">
            <input type="hidden" name="shift" value="{{ $currentShift ?? 'Pagi' }}">

            <!-- Checkbox: Guarantee Returned -->
            <div class="mt-4">
              <label class="flex items-center gap-2.5 text-xs text-slate-700 font-semibold cursor-pointer">
                <input type="checkbox" name="guarantee_returned" value="1" required class="rounded text-[#F5A623] focus:ring-amber-400">
                <span>Jaminan identitas ({{ $selectedTx->guarantee_type ?? 'KTP' }}) sudah dikembalikan — wajib</span>
              </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-5">
              <!-- Extend Stay Button -->
              <button type="button" onclick="extendCurrentStay({{ $selectedTx->id }})"
                      class="bg-white border border-stone-300 hover:bg-stone-50 text-[#0B192C] font-bold px-6 py-2.5 rounded-full text-xs shadow-xs transition-all active:scale-95">
                Extend Stay
              </button>
              
              <!-- Checkout & Buka Struk Button -->
              <button type="submit"
                      class="bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition-all active:scale-95">
                Checkout & Buka Struk
              </button>
            </div>

            <p class="text-[11px] text-slate-400 mt-3">
              Kamar otomatis jadi Dirty. Struk INV-YYYYMMDD-XXX terbuka di tab baru.
            </p>

          </form>
        @endif

      </div>

    </div>

  </div>

</div>

<!-- Extend Hidden Form -->
<form id="extendForm" method="POST" action="" class="hidden">
  @csrf
  <input type="hidden" name="additional_nights" id="extendNightsInput" value="1">
</form>

@push('scripts')
<script>
  let currentRoomPrice = 0;
  let currentTxBaseRate = {{ $selectedTx ? ($selectedTx->room->price_per_night * $selectedTx->duration) : 0 }};

  function calculateTotalBill() {
    const selector = document.getElementById('roomSelector');
    if (!selector) return;
    const selectedOption = selector.options[selector.selectedIndex];
    const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
    const duration = parseInt(document.getElementById('durationInput').value) || 1;
    const total = price * duration;
    document.getElementById('totalBillDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
  }

  function onRoomChanged() {
    const selector = document.getElementById('roomSelector');
    const selectedOption = selector.options[selector.selectedIndex];
    const roomNumber = selectedOption.getAttribute('data-number');
    const roomId = selector.value;
    
    document.getElementById('guestNameLabel').innerText = `Nama tamu (kosong = GUEST ROOM ${roomNumber})`;
    document.getElementById('frontOfficeCheckinForm').action = `/transactions/checkin/${roomId}`;
    calculateTotalBill();
  }

  function toggleTC(val) {
    document.getElementById('isTcInput').value = parseInt(val) > 0 ? '1' : '0';
  }

  function submitExpressCheckin() {
    document.getElementById('skipPrintCheckbox').checked = true;
    document.getElementById('frontOfficeCheckinForm').submit();
  }

  function onActiveTxChanged(txId) {
    window.location.href = `{{ route('checkin') }}?tx_id=${txId}`;
  }

  function recalcCheckout() {
    const addVal = parseInt(document.getElementById('coAdditionalInput').value) || 0;
    const finalTotal = currentTxBaseRate + addVal;
    document.getElementById('coBiayaTambahanText').innerText = 'Rp ' + addVal.toLocaleString('id-ID');
    document.getElementById('coPaidAmountInput').value = finalTotal;
  }

  function extendCurrentStay(txId) {
    const nights = prompt('Masukkan jumlah malam tambahan:', '1');
    if (nights && parseInt(nights) > 0) {
      const form = document.getElementById('extendForm');
      form.action = `/transactions/${txId}/extend`;
      document.getElementById('extendNightsInput').value = nights;
      form.submit();
    }
  }

  window.addEventListener('DOMContentLoaded', () => {
    calculateTotalBill();
  });
</script>
@endpush

@endsection
