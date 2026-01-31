<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ExpensesDetailSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, ShouldAutoSize
{
    protected $expenses;

    public function __construct($expenses)
    {
        $this->expenses = $expenses;
    }

    public function collection()
    {
        return $this->expenses;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kategori',
            'Deskripsi',
            'Jumlah',
            'Dicatat Oleh'
        ];
    }

    public function map($expense): array
    {
        return [
            Carbon::parse($expense->expense_date)->format('d/m/Y'),
            ucfirst($expense->category),
            $expense->description,
            'Rp ' . number_format($expense->amount, 0, ',', '.'),
            $expense->user->name ?? '-'
        ];
    }

    public function title(): string
    {
        return 'Detail Pengeluaran';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
