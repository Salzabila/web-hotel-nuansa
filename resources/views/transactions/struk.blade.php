<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    * { margin: 0; padding: 0; }
    body {
      font-family: 'Courier New', Courier, monospace;
      font-size: 12px;
      width: 58mm;
      margin: 0 auto;
      padding: 6px;
      color: #000;
    }
    .receipt { width: 100%; }
    .center { text-align: center; }
    .bold { font-weight: bold; }
    .line { border-top: 1px solid #000; margin: 6px 0; padding: 0; }
    .row { display: flex; justify-content: space-between; margin: 4px 0; }
    .label { width: 60%; }
    .value { width: 40%; text-align: right; }
    .total-row { font-weight: bold; font-size: 13px; border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 4px 0; margin: 6px 0; }
    .footer { font-size: 10px; margin-top: 6px; line-height: 1.3; }
    @media print {
      body { margin: 0; padding: 0; }
      .no-print { display: none; }
    }
  </style>
  <title>Struk</title>
</head>
<body onload="window.print();">
  <div class="receipt">
    <div class="center bold" style="font-size: 14px; margin-bottom: 4px;">HOTEL NUANSA</div>
    <div class="center" style="font-size: 10px; margin-bottom: 6px;">Sistem Manajemen Hotel</div>
    <div class="line"></div>

    <div class="center bold" style="margin: 4px 0;">STRUK TRANSAKSI</div>
    <div class="line"></div>

    <div class="row">
      <div class="label">Invoice</div>
      <div class="value bold">{{ $transaction->invoice_code }}</div>
    </div>
    <div class="row">
      <div class="label">Tanggal</div>
      <div class="value">{{ $transaction->check_in->format('d/m/Y H:i') }}</div>
    </div>
    <div class="line"></div>

    <div style="margin: 4px 0; font-size: 11px;">
      <div>Nama: <strong>{{ $transaction->guest_name }}</strong></div>
      <div style="margin-top: 4px;">NIK: {{ $transaction->guest_nik ?? '-' }}</div>
      @if($transaction->guest_address)
        <div style="margin-top: 4px;">Alamat: {{ Str::limit($transaction->guest_address, 40) }}</div>
      @endif
    </div>
    <div class="line"></div>

    <div style="margin: 4px 0;">
      <div class="row"><div class="label">Kamar</div><div class="value bold">{{ $transaction->room->room_number }}</div></div>
      <div class="row"><div class="label">Tipe</div><div class="value">{{ $transaction->room->type }}</div></div>
    </div>
    <div class="line"></div>

    <div style="margin: 4px 0;">
      <div class="row"><div class="label">Check-in</div><div class="value">{{ $transaction->check_in->format('d/m/Y') }}</div></div>
      <div class="row"><div class="label">Check-out</div><div class="value">{{ $transaction->check_out->format('d/m/Y') }}</div></div>
      <div class="row"><div class="label">Durasi</div><div class="value bold">{{ $transaction->check_in->diffInDays($transaction->check_out) }} malam</div></div>
    </div>
    <div class="line"></div>

    <div style="margin: 4px 0;">
      <div class="row"><div class="label">Harga/Malam</div><div class="value">Rp {{ number_format($transaction->room->price, 0, ',', '.') }}</div></div>
      <div class="total-row">
        <div class="row"><div class="label">TOTAL BAYAR</div><div class="value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div></div>
      </div>
    </div>

    <div style="margin: 6px 0; font-size: 10px;">
      @if($transaction->is_ktp_held)
        <div class="center bold" style="color: #d32f2f; margin: 4px 0;">⚠ KTP DITAHAN</div>
      @endif
      <div style="margin-top: 6px; border-top: 1px solid #000; padding-top: 6px;">
        <div class="center bold">SYARAT PENGAMBILAN KTP</div>
        <div class="center" style="margin-top: 4px;">Tunjukkan struk ini saat mengambil KTP</div>
      </div>
    </div>

    <div class="line"></div>
    <div class="footer center" style="margin-top: 6px;">
      <div>Petugas: {{ $transaction->user->name }}</div>
      <div style="margin-top: 4px;">{{ now()->format('d M Y H:i') }}</div>
      <div style="margin-top: 6px;">Terima kasih telah menginap di Hotel Nuansa</div>
    </div>
  </div>
</body>
</html>
