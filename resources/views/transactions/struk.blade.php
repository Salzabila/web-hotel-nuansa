<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Courier New', Courier, monospace;
      font-size: 10px;
      width: 58mm;
      margin: 0 auto;
      padding: 6px;
      color: #000;
      background: #fff;
      line-height: 1.3;
    }
    .center { text-align: center; }
    .right { text-align: right; }
    .separator { 
      border-top: 1px dashed #000; 
      margin: 4px 0; 
    }
    .line { 
      border-top: 1px solid #000; 
      margin: 4px 0; 
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    td {
      padding: 2px 0;
      vertical-align: top;
    }
    .col-qty {
      width: 12px;
      text-align: left;
    }
    .col-name {
      padding: 0 4px;
    }
    .col-price {
      text-align: right;
      white-space: nowrap;
    }
    @media print {
      body { margin: 0; padding: 6px; }
      @page { margin: 0; }
    }
  </style>
  <title>Struk</title>
</head>
<body onload="window.print();">
  @php
    // Calculate duration in days, rounded UP (Ceiling)
    $durationDays = ceil($tx->check_in->diffInDays($tx->check_out, false));
    
    // Ensure minimum 1 night charge
    if ($durationDays < 1) $durationDays = 1;
    
    // Calculate subtotal
    $subtotal = $tx->room->price_per_night * $durationDays;
    $service = 0; // Service fee 5% if applicable
    $pb1 = 0; // Tax if applicable
    $grandTotal = $tx->total_price;
  @endphp
  
  <!-- Header -->
  <div class="center" style="margin-bottom: 2px; font-size: 9px;">HOTEL NUANSA</div>
  <div class="center" style="margin-bottom: 2px; font-size: 8px;">Jl. Raya Utama No. 45</div>
  <div class="center" style="margin-bottom: 4px; font-size: 8px;">Telp: (0274) 556789</div>
  
  <div class="separator"></div>
  
  <!-- Invoice Info -->
  <div style="margin: 4px 0;">
    <div>Invoice : {{ $tx->invoice_code }}</div>
    <div>Tanggal : {{ $tx->created_at->format('d/m/y H:i') }}</div>
    <div>Lodge   : {{ $tx->room->room_number }}</div>
  </div>
  
  <div class="separator"></div>
  
  <!-- Items -->
  <table style="margin: 4px 0;">
    <tr>
      <td class="col-qty">{{ $durationDays }}</td>
      <td class="col-name">Kamar {{ $tx->room->room_number }}</td>
      <td class="col-price">{{ number_format($tx->room->price_per_night, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td class="col-qty"></td>
      <td class="col-name" style="font-size: 9px;">Tamu: {{ $tx->guest_name }}</td>
      <td class="col-price">{{ number_format($subtotal, 0, ',', '.') }}</td>
    </tr>
  </table>
  
  <div style="margin: 4px 0; font-size: 8px;">
    <div>Check-in : {{ $tx->check_in->format('d/m/y H:i') }}</div>
    <div>Check-out: {{ $tx->check_out->format('d/m/y H:i') }}</div>
    <div>Durasi   : {{ $durationDays }} malam</div>
  </div>
  
  <div class="separator"></div>
  
  <!-- Totals -->
  <table style="margin: 4px 0;">
    <tr>
      <td>Subtotal</td>
      <td class="right">{{ number_format($subtotal, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Service 5%</td>
      <td class="right">{{ number_format($service, 2, ',', '.') }}</td>
    </tr>
    <tr>
      <td>PB1</td>
      <td class="right">{{ number_format($pb1, 2, ',', '.') }}</td>
    </tr>
  </table>
  
  <div class="line"></div>
  
  <table style="font-weight: bold; margin: 4px 0;">
    <tr>
      <td>Total:</td>
      <td class="right">{{ number_format($grandTotal, 2, ',', '.') }}</td>
    </tr>
  </table>
  
  <div class="line"></div>
  
  <!-- KTP Warning -->
  @if($tx->is_ktp_held)
  <div class="center" style="margin: 6px 0; font-weight: bold;">
    ** KTP DITAHAN **
  </div>
  <div class="center" style="margin-bottom: 4px; font-size: 8px;">
    Tunjukkan struk saat pengambilan KTP
  </div>
  <div class="separator"></div>
  @endif
  
  <!-- Footer -->
  <div class="center" style="margin: 6px 0;">
    <div style="margin-bottom: 4px;">TERIMA KASIH</div>
    <div style="font-size: 8px;">Petugas: {{ $tx->user->name }}</div>
    <div style="font-size: 8px; margin-top: 2px;">{{ now()->format('d/m/Y H:i:s') }}</div>
  </div>
</body>
</html>
