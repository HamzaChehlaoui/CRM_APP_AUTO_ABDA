<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Car;
use App\Models\Invoice;
use App\Exports\GenericExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormats;

class ExportController extends Controller
{
    private const EXPORTABLE_FIELDS = [
        'clients' => [
            'id' => 'ID',
            'full_name' => 'Nom complet',
            'phone' => 'Téléphone',
            'cin' => 'CIN',
            'address' => 'Adresse',
            'email' => 'Email',
            'created_at' => 'Date de création',
        ],
        'cars' => [
            'id' => 'ID',
            'brand' => 'Marque',
            'model' => 'Modèle',
            'ivn' => 'IVN',
            'registration_number' => 'Immatriculation',
            'chassis_number' => 'N° de châssis',
            'client.full_name' => 'Client',
            'created_at' => 'Date de création',
        ],
        'invoices' => [
            'id' => 'ID',
            'invoice_number' => 'N° Facture',
            'sale_date' => 'Date de vente',
            'total_amount' => 'Montant TTC',
            'statut_facture' => 'Statut',
            'client.full_name' => 'Client',
            'car.registration_number' => 'Voiture (Immat.)',
        ]
    ];


    public function showExportPage()
    {
        return view('page.exporter', [
            'clientFields' => self::EXPORTABLE_FIELDS['clients'],
            'carFields' => self::EXPORTABLE_FIELDS['cars'],
            'invoiceFields' => self::EXPORTABLE_FIELDS['invoices'],
        ]);
    }

    public function handleExport(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:clients,cars,invoices,all',
            'export_format' => 'required|in:xlsx,csv,pdf',
            'selected_fields' => 'required|json',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $dataType = $request->input('data_type');
        $format = $request->input('export_format');
        $selectedFields = json_decode($request->input('selected_fields'), true);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($dataType === 'all') {

            return back()->withErrors('La fonctionnalité "Tous les types" n\'est pas encore implémentée.');
        }

        [$model, $query] = $this->getModelAndQuery($dataType);


        $dateColumn = ($dataType === 'invoices') ? 'sale_date' : 'created_at';
        if ($startDate) {
            $query->whereDate($dateColumn, '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate($dateColumn, '<=', $endDate);
        }

        $tablePrefix = Str::plural($dataType); // clients, cars, invoices
        $fieldsForExport = [];
        $headings = [];

        foreach ($selectedFields as $fullFieldName) {
            if (Str::startsWith($fullFieldName, $tablePrefix)) {
                $fieldName = Str::after($fullFieldName, $tablePrefix . '.');
                $fieldsForExport[] = $fieldName;
                $headings[] = self::EXPORTABLE_FIELDS[$dataType][$fieldName] ?? Str::studly($fieldName);
            }
        }

        if (empty($fieldsForExport)) {
            return back()->withErrors('Veuillez sélectionner des champs valides pour le type de données choisi.');
        }

        $export = new GenericExport($query, $headings, $fieldsForExport);
        $fileName = "export_{$dataType}_" . now()->format('Y-m-d_H-i') . ".{$format}";

        $formatConstant = match(strtoupper($format)) {
            'CSV' => ExcelFormats::CSV,
            'PDF' => ExcelFormats::DOMPDF,
            default => ExcelFormats::XLSX,
        };

        return Excel::download($export, $fileName, $formatConstant);
    }


    private function getModelAndQuery(string $dataType): array
    {
        switch ($dataType) {
            case 'clients':
                return [Client::class, Client::query()];
            case 'cars':
                return [Car::class, Car::with('client')];
            case 'invoices':
                return [Invoice::class, Invoice::with('client', 'car')];
            default:
                throw new \Exception("Type de données non supporté: {$dataType}");
        }
    }
}
