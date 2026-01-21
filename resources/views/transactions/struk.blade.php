<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Courier New', Courier, monospace;
      font-size: 11px;
      width: 80mm;
      margin: 0 auto;
      padding: 8px;
      color: #000;
      background: #fff;
      line-height: 1.5;
    }
    .center { text-align: center; }
    .right { text-align: right; }
    .bold { font-weight: bold; }
    .separator { border-top: 1px dashed #000; margin: 6px 0; }
    .line { border-top: 1px solid #000; margin: 6px 0; }
    .double-line { border-top: 2px double #000; margin: 8px 0; }
    
    table { width: 100%; border-collapse: collapse; }
    td { padding: 2px 0; vertical-align: top; }
    .qty { width: 15px; }
    .item { padding-right: 5px; }
    .price { text-align: right; white-space: nowrap; }
    
    @media print {
      body { margin: 0; padding: 8px; }
      @page { size: 80mm auto; margin: 0; }
    }
  </style>
  <title>{{ $tx->invoice_code }}</title>
</head>
<body onload="window.print();">
  @php
    $durationDays = $tx->duration;
    $subtotal = $tx->room->price_per_night * $durationDays;
    $additionalCharges = $tx->additional_charges ?? 0;
    $grandTotal = $tx->total_price;
    $paidAmount = $tx->paid_amount ?? 0;
    $change = $paidAmount - $grandTotal;
    $shift = $tx->shift ?? 'Pagi';
  @endphp
  
  <!-- Logo -->
  <div class="center" style="margin-bottom: 8px;">
    <img src="{{ asset('images/logo nuansa.jpg') }}" alt="Nuansa Hotel" style="width: 140px; height: auto;">
  </div>
  
  <div class="center" style="font-size: 9px;">Jl. Letjen Sutoyo No. 59-60</div>
  <div class="center" style="font-size: 9px; margin-bottom: 6px;">Medaeng - Waru - Sidoarjo</div>
  
  <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
  
  <table style="font-size: 10px; margin: 4px 0;">
    <tr><td class="bold">{{ $tx->invoice_code }}</td><td class="right">{{ $tx->created_at->format('d/m/Y H:i') }}</td></tr>
    <tr><td colspan="2">Shift : {{ $shift }}</td></tr>
  </table>
  
  <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
  
  <div style="font-size: 10px; margin: 4px 0;">
    <table style="width: 100%;">
      <tr><td style="width: 65px;">Pelanggan</td><td>: <span class="bold">{{ strtoupper($tx->guest_name) }}</span></td></tr>
      <tr><td>Alamat</td><td>: {{ $tx->guest_address ?: '-' }}</td></tr>
      <tr><td>Kamar</td><td>: <span class="bold">{{ $tx->room->room_number }}</span> - {{ $tx->room->type }}</td></tr>
    </table>
  </div>
  
  <div style="font-size: 9px; margin: 8px 0 4px 0;">
    <table style="width: 100%;">
      <tr><td style="width: 65px;">Check-in</td><td>: {{ $tx->check_in->format('d/m/Y') }} ({{ $tx->check_in->format('H:i') }})</td></tr>
      <tr><td>Check-out</td><td>: {{ $tx->check_out->format('d/m/Y') }} ({{ $tx->check_out->format('H:i') }})</td></tr>
      <tr><td>Waktu</td><td>: {{ $durationDays }} malam</td></tr>
    </table>
  </div>
  
  <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
  
  <table style="font-size: 10px;">
    <tr>
      <td class="qty">{{ $durationDays }}</td>
      <td class="item">Kamar {{ $tx->room->room_number }}</td>
      <td class="price">{{ number_format($subtotal, 0, ',', '.') }}</td>
    </tr>
    @if($additionalCharges > 0)
    <tr>
      <td class="qty">1</td>
      <td class="item">Biaya Tambahan</td>
      <td class="price">{{ number_format($additionalCharges, 0, ',', '.') }}</td>
    </tr>
    @endif
  </table>
  
  <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
  
  <table style="font-size: 10px;">
    <tr><td>Subtotal</td><td class="price">Rp {{ number_format($subtotal, 0, ',', '.') }}</td></tr>
    @if($additionalCharges > 0)
    <tr><td>Biaya Tambahan</td><td class="price">Rp {{ number_format($additionalCharges, 0, ',', '.') }}</td></tr>
    @endif
  </table>
  
  <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
  
  <table style="font-size: 10px;">
    <tr><td colspan="2" style="font-style: italic; color: #555;">Harga per malam: Rp {{ number_format($tx->room->price_per_night, 0, ',', '.') }}</td></tr>
  </table>
  
  <table style="font-size: 12px; font-weight: bold;">
    <tr><td>TOTAL</td><td class="price">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td></tr>
  </table>
  
  <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
  
  @if($paidAmount > 0)
  <table style="font-size: 10px;">
    <tr><td>Dibayar</td><td class="price">Rp {{ number_format($paidAmount, 0, ',', '.') }}</td></tr>
    <tr class="bold"><td>Kembalian</td><td class="price">Rp {{ number_format($change, 0, ',', '.') }}</td></tr>
  </table>
  @endif
  
  <div class="center bold" style="margin: 12px 0 8px 0; padding: 6px 0; {{ $tx->payment_status === 'paid' ? 'background: #000; color: #fff;' : 'border: 1px solid #000;' }}">
    @if($tx->payment_status === 'paid')
       LUNAS 
    @elseif($tx->payment_status === 'partial')
      BELUM LUNAS<br><span style="font-size: 9px;">Sisa: Rp {{ number_format($grandTotal - $paidAmount, 0, ',', '.') }}</span>
    @else
      BELUM DIBAYAR
    @endif
  </div>
  
  <div class="center" style="font-size: 9px; margin: 8px 0 4px 0;">
    Kasir: <span class="bold">{{ $tx->cashier_name ?? $tx->user->name }}</span>
  </div>
  
  <div class="center" style="font-size: 8px; margin: 8px 0 4px 0;">Barang hilang/rusak bukan tanggung jawab kami</div>
  <div class="center" style="font-size: 8px; margin-bottom: 6px;">Simpan struk ini sebagai bukti pembayaran</div>
  
  <div class="center" style="font-size: 8px; margin: 6px 0;">CS: 0889-9429-8505 / 0812-1543-0838</div>
  <div class="center bold" style="margin: 6px 0; font-size: 10px;">TERIMA KASIH</div>

</body>
</html>
