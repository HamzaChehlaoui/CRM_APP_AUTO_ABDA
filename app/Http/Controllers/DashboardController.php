<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Suivi;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request, DashboardService $dashboardService)
{
    $user = auth()->user();
    $selectedBranch = $request->get('branch_filter', 'all');
    $period = $request->get('period', 'week');

    // Spécifier les branches et les demandes
    $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);

    // Statistiques générales
    $stats = $dashboardService->getDashboardStats(
        $data['clientsQuery'],
        $data['suivisQuery'],
        $data['invoicesQuery']
    );

    /// Clients vendus par terme
    [$clientsVendus, $labels] = $dashboardService->getClientsVendus($data['invoicesQuery'], $period);

    return view('page.dashboard', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clientsVendus' => $clientsVendus,
        'labels' => $labels,
    ]));
}
  public function postSaleStats(Request $request, DashboardService $dashboardService)
{
    $user = auth()->user();
    $selectedBranch = $request->get('branch_filter', 'all');

    $stats = $dashboardService->getPostSaleStats($user, $selectedBranch);

    return response()->json($stats);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
