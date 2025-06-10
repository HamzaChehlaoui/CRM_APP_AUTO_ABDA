<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatisticsExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $statistics;

    public function __construct($statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * @return array
     */
    public function array(): array
    {
       
        // FIX: The header row was removed from here because the headings() method handles it.
        return [
            ['Period', $this->statistics['period']],
            ['Total Clients', $this->statistics['total_clients']],
            ['Total Sales', $this->statistics['total_sales']],
            // Formatting the number here is good practice.
            ['Total Revenue', number_format($this->statistics['total_revenue'] ?? 0, 2, '.', '')],
            ['Active Suivis', $this->statistics['active_suivis']],
            ['Generated At', $this->statistics['generated_at']],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // This will be the first row of the Excel file.
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        // This makes the first row (the headings) bold.
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
