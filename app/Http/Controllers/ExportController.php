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
use App\Exports\AllDataExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

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
            'accord_reference'=> 'Accord / Contrat (accord)',
            'purchase_order_number' => 'Bon de commande (bc)',
            'delivery_note_number' => 'Bon de livraison (bl)',
            'payment_order_reference' => 'Ordre de règlement (or)',
            'car.registration_number' => 'Voiture (Immat.)',
        ]
    ];

   public function showExportPage()
{
    $user = Auth::user();
    $branches = collect();

    if ($user->role_id == 1 || $user->role_id == 2) {
        $branches = Branch::all();
    }

    return view('page.exporter', [
        'clientFields' => self::EXPORTABLE_FIELDS['clients'],
        'carFields' => self::EXPORTABLE_FIELDS['cars'],
        'invoiceFields' => self::EXPORTABLE_FIELDS['invoices'],
        'branches' => $branches,
    ]);

    }

    public function handleExport(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        $request->validate([
            'data_type' => 'required|in:clients,cars,invoices,all',
            'export_format' => 'required|in:xlsx,csv,pdf',
            'selected_fields' => 'required|json',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'branch_id' => 'nullable|string',
        ]);
        $user = Auth::user();
    $effectiveBranchId = null;
    if ($user->role_id == 1 || $user->role_id == 2) {
        $effectiveBranchId = $request->input('branch_id');
    } else {
        $effectiveBranchId = $user->branch_id;
    }

        $dataType = $request->input('data_type');
        $format = $request->input('export_format');
        $selectedFields = json_decode($request->input('selected_fields'), true);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // DEBUG: Log the received data
        Log::info('Export Request Debug:', [
            'dataType' => $dataType,
            'selectedFields' => $selectedFields,
            'format' => $format
        ]);

        if ($dataType === 'all') {
            $sheetsData = [];
            $dataTypes = ['clients', 'cars', 'invoices'];

            foreach ($dataTypes as $type) {
                // DEBUG: Log filtering for each type
                Log::info("Processing type: {$type}");

                $fieldsForType = array_filter($selectedFields, function($field) use ($type) {
                    $matches = Str::startsWith($field, $type . '.');
                    Log::info("Field: {$field}, Type: {$type}, Matches: " . ($matches ? 'YES' : 'NO'));
                    return $matches;
                });

                Log::info("Fields for {$type}:", $fieldsForType);

                if (!empty($fieldsForType)) {
                    // Convert field names to remove the type prefix for processing
                    $cleanedFields = array_map(function($field) use ($type) {
                        return Str::after($field, $type . '.');
                    }, $fieldsForType);

                    Log::info("Cleaned fields for {$type}:", $cleanedFields);

        $sheetInfo = $this->prepareSheetData($type, $cleanedFields, $startDate, $endDate, $effectiveBranchId);

                    // DEBUG: Log query and data count
                    $data = $sheetInfo['query']->get();
                    Log::info("Data count for {$type}: " . $data->count());

                    $sheetInfo['data'] = $data;
                    unset($sheetInfo['query']);

                    $sheetsData[$type] = $sheetInfo;
                } else {
                    Log::info("No fields found for type: {$type}");
                }
            }

            Log::info('Final sheets data structure:', array_keys($sheetsData));

            if (empty($sheetsData)) {
                return back()->withErrors('Veuillez sélectionner au moins un champ à exporter.');
            }

            $export = new AllDataExport($sheetsData);
            $fileName = "export_complet_" . now()->format('Y-m-d') . ".xlsx";

            return Excel::download($export, $fileName, ExcelFormats::XLSX);
        }

        // For single data type exports
        $cleanedFields = array_map(function($field) use ($dataType) {
            return Str::after($field, $dataType . '.');
        }, $selectedFields);

    $sheetInfo = $this->prepareSheetData($dataType, $cleanedFields, $startDate, $endDate, $effectiveBranchId);

        if (empty($sheetInfo['fields'])) {
            return back()->withErrors('Veuillez sélectionner des champs valides pour le type de données choisi.');
        }

        $data = $sheetInfo['query']->get();

        $export = new GenericExport($data, $sheetInfo['headings'], $sheetInfo['fields']);
        $fileName = "export_{$dataType}_" . now()->format('Y-m-d_H-i') . ".{$format}";

        $formatConstant = match(strtoupper($format)) {
            'CSV' => ExcelFormats::CSV,
            'PDF' => ExcelFormats::DOMPDF,
            default => ExcelFormats::XLSX,
        };

        return Excel::download($export, $fileName, $formatConstant);
    }

private function prepareSheetData(string $type, array $selectedFields, ?string $startDate, ?string $endDate, ?string $branchId): array
    {
        [, $query] = $this->getModelAndQuery($type);

        $dateColumn = ($type === 'invoices') ? 'sale_date' : 'created_at';
        if ($startDate) {
            $query->whereDate($dateColumn, '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate($dateColumn, '<=', $endDate);
        }
        if ($branchId && $branchId !== 'all') {
        if ($type === 'clients') {
            $query->where('branch_id', $branchId);
        } elseif ($type === 'cars' || $type === 'invoices') {
            $query->whereHas('client', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }
    }

        $fieldsForExport = [];
        $headings = [];

        foreach ($selectedFields as $fieldName) {
            if (isset(self::EXPORTABLE_FIELDS[$type][$fieldName])) {
                $fieldsForExport[] = $fieldName;
                $headings[] = self::EXPORTABLE_FIELDS[$type][$fieldName];
            } else {
                Log::warning("Field {$fieldName} not found in exportable fields for {$type}");
            }
        }

        Log::info("Final fields for {$type}:", [
            'fieldsForExport' => $fieldsForExport,
            'headings' => $headings
        ]);

        return [
            'query' => $query,
            'headings' => $headings,
            'fields' => $fieldsForExport,
        ];
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
