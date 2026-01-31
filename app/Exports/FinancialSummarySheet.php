<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinancialSummarySheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    protected $revenue;
    protected $totalExpenses;
    protected $tcCommission;
    protected $netProfit;
    protected $startDate;
    protected $endDate;

    public function __construct($revenue, $totalExpenses, $tcCommission, $netProfit, $startDate, $endDate)
    {
        $this->revenue = $revenue;
        $this->totalExpenses = $totalExpenses;
        $this->tcCommission = $tcCommission;
        $this->netProfit = $netProfit;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        return [
            ['LAPORAN KEUANGAN HOTEL NUANSA'],
            ['Periode', $this->startDate->format('d F Y') . ' - ' . $this->endDate->format('d F Y')],
            [''],
            ['PENDAPATAN', 'Rp ' . number_format($this->revenue, 0, ',', '.')],
            ['PENGELUARAN', 'Rp ' . number_format($this->totalExpenses, 0, ',', '.')],
            ['KOMISI TC', 'Rp ' . number_format($this->tcCommission, 0, ',', '.')],
            [''],
            ['LABA BERSIH', 'Rp ' . number_format($this->netProfit, 0, ',', '.')],
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            'A4:A8' => ['font' => ['bold' => true]],
        ];
    }
}
