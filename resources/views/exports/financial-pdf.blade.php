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
        .financial-summary {
            margin: 20px 0;
            background: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 14px;
        }
        .financial-summary .title {
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .summary-table {
            width: 100%;
            background: #ffffff;
            border: 1px solid #dfe7f1;
        }
        .summary-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-table td {
            padding: 10px 12px;
            font-size: 9pt;
        }
        .summary-table .label-cell {
            color: #475569;
            font-weight: 600;
            width: 60%;
        }
        .summary-table .value-cell {
            text-align: right;
            font-weight: bold;
            color: #111827;
            width: 40%;
        }
        .summary-table .total-row {
            background: #f3f4f6;
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
        }
        .summary-table .total-row td {
            padding: 12px;
            font-size: 10pt;
        }
        .summary-table .profit-positive { color: #047857; }
        .summary-table .profit-negative { color: #dc2626; }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 22px 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #0f172a;
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
        .text-right { text-align: right; }
        .text-center { text-align: center; }
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
                <td class="text-center">{{ \Carbon\Carbon::parse($expense->date ?? $expense->expense_date)->format('d/m/Y') }}</td>
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
