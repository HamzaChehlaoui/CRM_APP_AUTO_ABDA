<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GenericExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    use Exportable;

    protected Collection $data;
    protected array $headings;
    protected array $fields;

    public function __construct(Collection $data, array $headings, array $fields)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->fields = $fields;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function map($row): array
    {
        $mappedRow = [];
        foreach ($this->fields as $field) {
            if (str_contains($field, '.')) {
                $relations = explode('.', $field);
                $value = $row;
                foreach ($relations as $relation) {
                    if (is_null($value)) {
                        $value = null;
                        break;
                    }
                    $value = $value->{$relation} ?? null;
                }
                $mappedRow[] = $value;
            } else {
                $mappedRow[] = $row->{$field};
            }
        }
        return $mappedRow;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '1E90FF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                foreach (range('A', 'Z') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setWidth(25);
                }

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $cellRange = 'A1:' . $highestColumn . $highestRow;

                $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
