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
    ->get();

    return view('page.clients', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clients' =>$clients,
    ]));
}
    public function create()
{
    // $userBranchId = auth()->user()->branch_id;
    return view('page.factures', compact('userBranchId'));
}

public function store(StoreClientRequest $request)
{
    $validated = $request->validated();

    try {
        $client = Client::create([
            'full_name' => $validated['client']['full_name'],
            'phone' => $validated['client']['phone'],
            'cin' => $validated['client']['cin'],
            'address' => $validated['client']['address'] ?? null,
            'email' => $validated['client']['email'] ?? null,
            'branch_id' => $validated['client']['branch_id'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('client.index')->with('success', 'Client créé avec succès.');
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error creating client: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return back()->withErrors(['error' => 'Erreur lors de la création du client : ' . $e->getMessage()])->withInput();
    }
}
    public function show(Client $client)
    {
        $client->load(['invoices', 'suivis', 'reclamations']);
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
