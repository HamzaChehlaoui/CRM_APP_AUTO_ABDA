<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Throwable;

class GenericExport implements FromCollection, WithHeadings, WithMapping
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

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * @param mixed $row
     * @return array
     */
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
}
