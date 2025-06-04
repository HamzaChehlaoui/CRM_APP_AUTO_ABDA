<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
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
    ->paginate(3);

    return view('page.clients', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clients' =>$clients,
    ]));
}
    public function create()
{
    // $userBranchId = auth()->user()->branch_id;
    return view('page.clients', compact('userBranchId'));
}

public function storeAll(StoreClientRequest $request)
{
    $validated = $request->validated();

    Log::info('Validated data:', $validated); // Log validated data for debugging

    DB::beginTransaction();

    try {
        // Create client and verify
        $client = Client::create([
            'full_name' => $validated['client']['full_name'],
            'phone' => $validated['client']['phone'],
            'cin' => $validated['client']['cin'],
            'address' => $validated['client']['address'] ?? null,
            'email' => $validated['client']['email'] ?? null,
            'branch_id' => $validated['client']['branch_id'],
            'created_by' => auth()->id(),
            'post_sale_status' => 'en_attente_livraison',
        ]);

        // Check if client was created successfully
        if (!$client || !$client->id) {
            Log::error('Client creation failed', ['client' => $client]);
            throw new \Exception('Échec de la création du client.');
        }

        Log::info('Client created successfully', ['client_id' => $client->id]);

        // Create car
        $car = Car::create([
            'brand' => $validated['car']['brand'],
            'model' => $validated['car']['model'],
            'ivn' => $validated['car']['ivn'],
            'registration_number' => $validated['car']['registration_number'],
            'chassis_number' => $validated['car']['chassis_number'],
            'color' => $validated['car']['color'] ?? null,
            'year' => $validated['car']['year'] ?? null,
            'client_id' => $client->id,
            'branch_id' => $client->branch_id,
            'created_by' => auth()->id(),
        ]);

        // Check if car was created successfully
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

        return redirect()->route('client.index')->with('success', 'Le client, la voiture et la facture ont été enregistrés avec succès.');

    } catch (\Exception $e) {
    //    dd($e);
        DB::rollBack();
        Log::error('Error in storeAll: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return back()->withErrors(['error' => 'Erreur lors de l’enregistrement : ' . $e->getMessage()])->withInput();
    }
}

    public function show(Client $client)
    {
        $client->load(['invoices', 'suivis', 'reclamations', 'entretiens']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
