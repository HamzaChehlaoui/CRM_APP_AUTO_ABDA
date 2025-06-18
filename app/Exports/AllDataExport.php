<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    use Exportable;

    protected array $sheets;

    public function __construct(array $sheets)
    {
        $this->sheets = $sheets;
    }

    /**
     * @return array
     */
    public function sheets(): array
{
    $sheetsToExport = [];
    foreach ($this->sheets as $sheetName => $sheetData) {
        if (!empty($sheetData['fields'])) {
            $sheetsToExport[ucfirst($sheetName)] = new GenericExport(
                $sheetData['data'],
                $sheetData['headings'],
                $sheetData['fields']
            );
        }
    }
    return $sheetsToExport;
}
}
