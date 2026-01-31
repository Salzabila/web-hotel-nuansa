<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Nama Pelanggan',
            'No. KTP',
            'No. Telepon',
            'Kamar',
            'Check-in',
            'Check-out',
            'Durasi (Malam)',
            'Harga per Malam',
            'Total Harga',
            'Metode Pembayaran',
            'Komisi TC',
            'Status',
            'Kasir'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->invoice_code,
            $transaction->guest_name,
            $transaction->guest_id_card,
            $transaction->guest_phone,
            $transaction->room->room_number ?? '-',
            $transaction->check_in->format('d/m/Y H:i'),
            $transaction->check_out ? $transaction->check_out->format('d/m/Y H:i') : '-',
            $transaction->duration_nights,
            'Rp ' . number_format($transaction->price_per_night, 0, ',', '.'),
            'Rp ' . number_format($transaction->total_price, 0, ',', '.'),
            $transaction->payment_method === 'cash' ? 'Tunai' : 'Travel Company',
            'Rp ' . number_format($transaction->tc_commission ?? 0, 0, ',', '.'),
            $transaction->status === 'active' ? 'Aktif' : 'Selesai',
            $transaction->user->name ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
