<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 8mm 8mm;
            size: A4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: auto;
            min-height: 297mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #111827;
            line-height: 1.45;
        }
        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }
        th, td {
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .document-header {
            text-align: center;
            padding: 8px 0 14px 0;
            border-bottom: 2px solid #0f172a;
            margin-bottom: 18px;
        }
        .document-header .company-name {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .document-header .address {
            font-size: 7.5pt;
            color: #475569;
            margin-top: 2px;
        }
        .document-header .document-title {
            margin-top: 10px;
            font-size: 12pt;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: 0.5px;
        }
        .info-section {
            background: #f8fafc;
            border: 1px solid #dfe7f1;
            padding: 12px 14px;
            margin-bottom: 16px;
        }
        .info-section td {
            padding: 4px 0;
            font-size: 9pt;
        }
        .info-section .label {
            width: 140px;
            color: #475569;
            font-weight: 600;
        }
        .info-section .separator {
            width: 18px;
            text-align: center;
            color: #64748b;
        }
        .summary-section {
            background: #eef4ff;
            border-left: 4px solid #2563eb;
            padding: 12px 14px;
            margin-bottom: 16px;
        }
        .summary-section .title {
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .summary-grid {
            width: 100%;
            display: table;
            border-collapse: collapse;
        }
        .summary-item {
            display: table-row;
        }
        .summary-item .label,
        .summary-item .value {
            display: table-cell;
            padding: 8px 10px;
            background: #ffffff;
            border: 1px solid #dfe7f1;
            font-size: 9pt;
        }
        .summary-item .label {
            font-weight: 600;
            color: #475569;
            width: 60%;
        }
        .summary-item .value {
            text-align: right;
            color: #111827;
            font-weight: bold;
            width: 40%;
        }
        .data-table {
            width: 100%;
            margin: 12px 0 0 0;
            font-size: 8pt;
            border: 1px solid #dfe7f1;
        }
        .data-table thead th {
            background: #0f172a;
            color: #ffffff;
            padding: 8px 6px;
            font-size: 7.8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            text-align: left;
            border-right: 1px solid #334155;
        }
        .data-table tbody td {
            padding: 7px 6px;
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }
        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 7pt;
            font-weight: bold;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }
        .status-active {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        .status-finished {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #22c55e;
        }
        .signature-area {
            margin-top: 28px;
        }
        .signature-grid {
            width: 100%;
            display: table;
            border-collapse: collapse;
        }
        .signature-cell {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 0 24px;
        }
        .signature-role {
            font-size: 8.8pt;
            font-weight: bold;
            margin-bottom: 42px;
            color: #374151;
        }
        .signature-name {
            display: inline-block;
            min-width: 160px;
            border-top: 1px solid #0f172a;
            padding-top: 6px;
            font-size: 8.5pt;
            color: #111827;
        }
        .document-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dfe7f1;
            text-align: center;
            font-size: 7pt;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="document-header">
        <div class="company-name">HOTEL NUANSA</div>
        <div class="address">Jl. Example No. 123, Kota, Provinsi | Telp: (0xx) xxx-xxxx | Email: info@hotelnuansa.com</div>
        <div class="document-title">{{ $title }}</div>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td class="label">Periode Laporan</td>
                <td class="separator">:</td>
                <td class="value">{{ $period }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td class="separator">:</td>
                <td class="value">{{ $generatedDate }}</td>
            </tr>
            <tr>
                <td class="label">Dibuat Oleh</td>
                <td class="separator">:</td>
                <td class="value">{{ $generatedBy }}</td>
            </tr>
        </table>
    </div>

    <div class="summary-section">
        <div class="title">Ringkasan Laporan</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total Transaksi</div>
                <div class="value">{{ $totalTransactions }} Transaksi</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 13%;">Invoice</th>
                <th style="width: 8%;">Kamar</th>
                <th style="width: 20%;">Nama Tamu</th>
                <th style="width: 10%;">Check In</th>
                <th style="width: 10%;">Check Out</th>
                <th style="width: 8%;">Durasi</th>
                <th style="width: 15%;">Total Harga</th>
                <th style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $tx->invoice_code }}</strong></td>
                    <td class="text-center">{{ $tx->room->room_number }}</td>
                    <td>{{ $tx->guest_name }}</td>
                    <td class="text-center">{{ $tx->check_in->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($tx->check_out)
                            {{ $tx->check_out->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $tx->duration_nights }} malam</td>
                    <td class="text-right"><strong>Rp {{ number_format($tx->total_price, 0, ',', '.') }}</strong></td>
                    <td class="text-center">
                        @if($tx->status === 'active')
                            <span class="status-badge status-active">Aktif</span>
                        @else
                            <span class="status-badge status-finished">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px;">Tidak ada data transaksi untuk periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-area">
        <div class="signature-grid">
            <div class="signature-cell">
                <div class="signature-role">Mengetahui,<br>Manager Hotel</div>
                <div class="signature-name">( _________________ )</div>
            </div>
            <div class="signature-cell">
                <div class="signature-role">Dibuat Oleh,<br>{{ $generatedBy }}</div>
                <div class="signature-name">( _________________ )</div>
            </div>
        </div>
    </div>

    <div class="document-footer">
        <p><strong>Hotel Nuansa</strong> - Dokumen ini dicetak otomatis oleh sistem dan sah tanpa tanda tangan basah.</p>
        <p>Untuk informasi lebih lanjut hubungi bagian administrasi hotel.</p>
    </div>
</body>
</html>
