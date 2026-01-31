<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 2cm;
            size: A4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            line-height: 1.5;
        }
        .document-header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #1a1a1a;
            margin-bottom: 20px;
        }
        .document-header .company-name {
            font-size: 18pt;
            font-weight: bold;
            color: #1a1a1a;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .document-header .document-title {
            font-size: 12pt;
            font-weight: bold;
            color: #333;
            margin-top: 8px;
        }
        .document-header .address {
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f9fafb;
            padding: 12px;
            border: 1px solid #e5e7eb;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section td {
            padding: 4px 0;
            font-size: 9pt;
            border: none;
        }
        .info-section .label {
            width: 150px;
            color: #4b5563;
            font-weight: 600;
        }
        .info-section .separator {
            width: 20px;
            text-align: center;
            color: #4b5563;
        }
        .info-section .value {
            color: #1a1a1a;
        }
        .summary-section {
            margin: 20px 0;
            background: #f3f4f6;
            padding: 15px;
            border-left: 4px solid #2563eb;
        }
        .summary-section .title {
            font-size: 10pt;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .summary-item {
            display: table-row;
        }
        .summary-item .label {
            display: table-cell;
            padding: 8px;
            background: white;
            border: 1px solid #e5e7eb;
            font-weight: 600;
            color: #4b5563;
            width: 60%;
        }
        .summary-item .value {
            display: table-cell;
            padding: 8px;
            background: white;
            border: 1px solid #e5e7eb;
            text-align: right;
            font-weight: bold;
            color: #1a1a1a;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 8pt;
        }
        .data-table thead {
            background: #374151;
            color: white;
        }
        .data-table th {
            padding: 10px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid #4b5563;
        }
        .data-table th:last-child {
            border-right: none;
        }
        .data-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .data-table td {
            padding: 8px 6px;
            border-right: 1px solid #f3f4f6;
        }
        .data-table td:last-child {
            border-right: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-badge {
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-active {
            background: #fef3c7;
            color: #78350f;
            border: 1px solid #fbbf24;
        }
        .status-finished {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        .signature-area {
            margin-top: 40px;
        }
        .signature-grid {
            display: table;
            width: 100%;
        }
        .signature-cell {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 0 20px;
        }
        .signature-role {
            font-weight: bold;
            margin-bottom: 60px;
            font-size: 9pt;
        }
        .signature-name {
            border-top: 1px solid #1a1a1a;
            padding-top: 5px;
            font-weight: bold;
            display: inline-block;
            min-width: 150px;
        }
        .document-footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 7pt;
            color: #6b7280;
        }
        .page-number:after {
            content: counter(page);
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
