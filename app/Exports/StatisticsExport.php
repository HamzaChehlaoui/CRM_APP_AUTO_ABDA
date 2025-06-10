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

    public function array(): array
    {
        return [
            ['Metric', 'Value'],
            ['Period', $this->statistics['period']],
            ['Total Clients', $this->statistics['total_clients']],
            ['Total Sales', $this->statistics['total_sales']],
            ['Total Revenue', number_format($this->statistics['total_revenue'], 2)],
            ['Active Suivis', $this->statistics['active_suivis']],
            ['Generated At', $this->statistics['generated_at']],
        ];
    }

    public function headings(): array
    {
        return ['Metric', 'Value'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
