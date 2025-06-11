<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class GenericExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected Builder $query;
    protected array $headings;
    protected array $fields;

    public function __construct(Builder $query, array $headings, array $fields)
    {
        $this->query = $query;
        $this->headings = $headings;
        $this->fields = $fields;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->query;
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
     *
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
