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
        .financial-summary {
            margin: 20px 0;
            background: #ecfdf5;
            padding: 15px;
            border-left: 4px solid #10b981;
        }
        .financial-summary .title {
            font-size: 10pt;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        .summary-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-table td {
            padding: 10px 12px;
            font-size: 9pt;
        }
        .summary-table .label-cell {
            color: #4b5563;
            font-weight: 600;
            width: 60%;
        }
        .summary-table .value-cell {
            text-align: right;
            font-weight: bold;
            color: #1a1a1a;
            width: 40%;
        }
        .summary-table .total-row {
            background: #f3f4f6;
            border-top: 2px solid #374151;
            border-bottom: 2px solid #374151;
        }
        .summary-table .total-row td {
            padding: 12px;
            font-size: 10pt;
        }
        .summary-table .profit-positive {
            color: #047857;
        }
        .summary-table .profit-negative {
            color: #dc2626;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1a1a1a;
            margin: 25px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
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

    <div class="financial-summary">
        <div class="title">Ringkasan Keuangan</div>
        <table class="summary-table">
            <tr>
                <td class="label-cell">Total Pendapatan dari Transaksi</td>
                <td class="value-cell">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Total Pengeluaran Operasional</td>
                <td class="value-cell">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Total Komisi TC</td>
                <td class="value-cell">Rp {{ number_format($tcCommission, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td class="label-cell">LABA BERSIH</td>
                <td class="value-cell {{ $netProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    Rp {{ number_format($netProfit, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Detail Pengeluaran Operasional</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Kategori</th>
                <th style="width: 35%;">Deskripsi</th>
                <th style="width: 20%;" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $index => $expense)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $expense->expense_date->format('d/m/Y') }}</td>
                <td>{{ ucfirst($expense->category) }}</td>
                <td>{{ $expense->description }}</td>
                <td class="text-right"><strong>Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada data pengeluaran operasional</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Ringkasan Transaksi</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Invoice</th>
                <th style="width: 25%;">Nama Tamu</th>
                <th style="width: 10%;">Kamar</th>
                <th style="width: 10%;">Durasi</th>
                <th style="width: 18%;" class="text-right">Total</th>
                <th style="width: 17%;" class="text-right">Komisi TC</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $tx->invoice_code }}</strong></td>
                <td>{{ $tx->guest_name }}</td>
                <td class="text-center">{{ $tx->room->room_number }}</td>
                <td class="text-center">{{ $tx->duration_nights }} malam</td>
                <td class="text-right">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($tx->tc_commission ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data transaksi</td>
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
        <p>Untuk informasi lebih lanjut hubungi bagian keuangan hotel.</p>
    </div>
</body>
</html>
