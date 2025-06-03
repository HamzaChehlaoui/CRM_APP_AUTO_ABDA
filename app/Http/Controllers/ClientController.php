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
    ->paginate(8);

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

    DB::beginTransaction();

    try {
        // إنشاء العميل
        $client = Client::create([
            'full_name' => $validated['client']['full_name'],
            'phone' => $validated['client']['phone'],
            'cin' => $validated['client']['cin'],
            'address' => $validated['client']['address'] ?? null,
            'email' => $validated['client']['email'] ?? null,
            'branch_id' => $validated['client']['branch_id'],
            'created_by' => auth()->id(),
            'post_sale_status' => 'en_attente_livraison', // القيمة الافتراضية
        ]);

        // إنشاء السيارة المرتبطة بالعميل
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

        // إنشاء الفاتورة المرتبطة بالعميل والسيارة
        $invoice = Invoice::create([
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
        ]);

        DB::commit();

        return redirect()->route('clients.index')->with('success', 'Le client, la voiture et la facture ont été enregistrés avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();

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
