<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Client;
use App\Models\Car;
use App\Models\Invoice;
use Carbon\Carbon;

class MultiSheetExport implements WithMultipleSheets
{
    use Exportable;

    protected $groupedFields;
    protected $dateRange;

    public function __construct(array $groupedFields, array $dateRange)
    {
        $this->groupedFields = $groupedFields;
        $this->dateRange = $dateRange;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $modelMap = [
            'clients' => Client::class,
            'cars' => Car::class,
            'invoices' => Invoice::class,
        ];

        foreach ($this->groupedFields as $type => $data) {
            if (isset($modelMap[$type])) {
                $model = $modelMap[$type];
                $query = $model::query()->select($data['fields']);

                if ($this->dateRange['start'] && $this->dateRange['end']) {
                    $dateColumn = ($type === 'invoices') ? 'sale_date' : 'created_at';
                    $query->whereBetween($dateColumn, [$this->dateRange['start'], $this->dateRange['end']]);
                }

                $sheets[] = new GenericExport(
                    $query,
                    $data['headings'],
                    ucfirst($type) // Sheet title e.g., "Clients"
                );
            }
        }

        return $sheets;
    }
}
