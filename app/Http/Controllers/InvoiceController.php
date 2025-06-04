<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Car;

class InvoiceController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService)
{
    $user = auth()->user();
    $selectedBranch = $request->get('branch_filter', 'all');
    $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);
    $stats = $dashboardService->getDashboardStats(
        $data['clientsQuery'],
        $data['suivisQuery'],
        $data['invoicesQuery']
    );
    $clients = $data['clientsQuery']
    ->with('cars')
    ->get();

    return view('page.factures', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clients' =>$clients,
    ]));
}

    public function create()
    {
        return view('invoices.create');
    }

    public function storeAll(StoreInvoiceRequest $request)
{
    $validated = $request->validated();

    Log::info('Validated data:', $validated);

    DB::beginTransaction();

    try {
        // Retrieve existing client
        $client = Client::findOrFail($validated['client_id']);
        Log::info('Client retrieved successfully', ['client_id' => $client->id]);

        // Create car
        $car = Car::create([
            'brand' => $validated['car']['brand'],
            'model' => $validated['car']['model'],
            'ivn' => $validated['car']['ivn'],
            'registration_number' => $validated['car']['registration_number'],
            'chassis_number' => $validated['car']['chassis_number'],
            'color' => $validated['car']['color'] ?? null,
            'year' => $validated['car']['year'] ?? null,
            'post_sale_status' => $validated['car']['post_sale_status'] ?? 'en_attente_livraison',
            'client_id' => $client->id,
            'branch_id' => $client->branch_id,
            'created_by' => auth()->id(),
        ]);

        if (!$car || !$car->id) {
            Log::error('Car creation failed', ['car' => $car]);
            throw new \Exception('Échec de la création de la voiture.');
        }

        // Prepare invoice data
        $invoiceData = [
            'invoice_number' => $validated['invoice']['invoice_number'],
            'sale_date' => $validated['invoice']['sale_date'],
            'total_amount' => $validated['invoice']['total_amount'],
            'accord_reference' => $validated['invoice']['accord_reference'] ?? null,
            'purchase_order_number' => $validated['invoice']['purchase_order_number'] ?? null,
            'delivery_note_number' => $validated['invoice']['delivery_note_number'] ?? null,
            'payment_order_reference' => $validated['invoice']['payment_order_reference'] ?? null,
            'client_id' => $client->id,
            'car_id' => $car->id,
            'user_id' => auth()->id(),
            'created_by' => auth()->id(),
        ];

        // Handle invoice image upload
        if ($request->hasFile('invoice.image')) {
            $imagePath = $request->file('invoice.image')->store('invoices', 'public');
            $invoiceData['image_path'] = $imagePath;
        }

        // Create invoice
        $invoice = Invoice::create($invoiceData);

        DB::commit();

        return redirect()->route('invoices.index')->with('success', 'Voiture et facture enregistrées avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error in storeAll: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return back()->withErrors(['error' => 'Erreur lors de l’enregistrement : ' . $e->getMessage()])->withInput();
    }
}

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'car', 'user', 'branch']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
