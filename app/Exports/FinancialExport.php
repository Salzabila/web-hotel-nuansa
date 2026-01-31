<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class FinancialExport implements WithMultipleSheets
{
    use Exportable;

    protected $revenue;
    protected $totalExpenses;
    protected $tcCommission;
    protected $netProfit;
    protected $expenses;
    protected $startDate;
    protected $endDate;

    public function __construct($revenue, $totalExpenses, $tcCommission, $netProfit, $expenses, $startDate, $endDate)
    {
        $this->revenue = $revenue;
        $this->totalExpenses = $totalExpenses;
        $this->tcCommission = $tcCommission;
        $this->netProfit = $netProfit;
        $this->expenses = $expenses;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new FinancialSummarySheet($this->revenue, $this->totalExpenses, $this->tcCommission, $this->netProfit, $this->startDate, $this->endDate),
            new ExpensesDetailSheet($this->expenses),
        ];
    }
}
