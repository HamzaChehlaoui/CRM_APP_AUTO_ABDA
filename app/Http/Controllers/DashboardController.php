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

    // Résoudre les données selon la branche
    $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);

    // Statistiques
    $stats = $dashboardService->getDashboardStats(
        $data['clientsQuery'],
        $data['suivisQuery'],
        $data['invoicesQuery']
    );

    // Derniers clients
    $clients = $data['clientsQuery']
        ->with('cars')
        ->take(8)
        ->get();

    // Top 5 clients payeurs : [clientsVendus, labels]
    [$clientsVendus, $labels] = $dashboardService->getTopPayingClients($data['invoicesQuery'], $period);

    // Retour à la vue
    return view('page.dashboard', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clients' => $clients,
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

}
