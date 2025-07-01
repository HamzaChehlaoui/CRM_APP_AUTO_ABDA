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

        // Create notification for the user who created the client
        \App\Http\Controllers\NotificationController::createNotification(
            auth()->id(),
            'Nouveau client créé',
            'Le client ' . $client->full_name . ' a été créé avec succès.',
            'client',
            auth()->id(),
            [
                'client_id' => $client->id
            ]
        );

        return redirect()->route('client.index')->with('success', 'Client créé avec succès.');
    } catch (\Exception $e) {

        Log::error('Error creating client: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return back()->withErrors(['error' => 'Erreur lors de la création du client : ' . $e->getMessage()])->withInput();
    }
}

}
