<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Suivi;
use App\Models\Branch;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StatisticsExport;
use Illuminate\Support\Facades\Log;
use App\Services\StatisticsService;

class StatistiquesController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $startDate = $request->filled('start_date') ? $request->get('start_date') : Carbon::now()->startOfMonth()->format('Y-m-d');
$endDate = $request->filled('end_date') ? $request->get('end_date') : Carbon::now()->endOfMonth()->format('Y-m-d');

        $selectedBranch = $request->get('branch', in_array($user->role_id, [1, 2]) ? 'all' : $user->branch_id);

        $branchData = $this->resolveBranchQueries($user, $selectedBranch);

        $generalStats = $this->statisticsService->getGeneralStatistics($startDate, $endDate, $branchData['clientsQuery'], $branchData['invoicesQuery'], $branchData['suivisQuery']);
        $invoiceStats = $this->statisticsService->getInvoiceStats($startDate, $endDate, $branchData['invoicesQuery']);
        $satisfactionData = $this->statisticsService->getSatisfactionData($startDate, $endDate, $branchData['suivisQuery']);
        $topPerformers = $this->statisticsService->getTopPerformers($startDate, $endDate, $branchData['usersQuery']);

        return view('page.statistiques', array_merge(
    // حذف 'salesByModel' هنا
    compact('satisfactionData', 'topPerformers', 'startDate', 'endDate'),
    $generalStats,
    [
        'branches' => $branchData['branches'],
        'selectedBranch' => $selectedBranch,
        'invoiceStats' => $invoiceStats,
    ]
));
    }

    private function resolveBranchQueries($user, $selectedBranch): array
    {
        if (in_array($user->role_id, [1, 2])) {
            $clientsQuery = Client::query();
            $suivisQuery = Suivi::query();
            $invoicesQuery = Invoice::query();
            $usersQuery = User::query();

            if ($selectedBranch !== 'all') {
                $clientsQuery->where('branch_id', $selectedBranch);
                $usersQuery->where('branch_id', $selectedBranch);
                $suivisQuery->whereHas('client', fn($q) => $q->where('branch_id', $selectedBranch));
                $invoicesQuery->whereHas('client', fn($q) => $q->where('branch_id', $selectedBranch));
            }
        } else {
            $branchId = $user->branch_id;
            $clientsQuery = Client::where('branch_id', $branchId);
            $suivisQuery = Suivi::whereHas('client', fn($q) => $q->where('branch_id', $branchId));
            $invoicesQuery = Invoice::whereHas('client', fn($q) => $q->where('branch_id', $branchId));
            $usersQuery = User::where('branch_id', $branchId);
        }

        return [
            'clientsQuery' => $clientsQuery,
            'suivisQuery' => $suivisQuery,
            'invoicesQuery' => $invoicesQuery,
            'usersQuery' => $usersQuery,

            'branches' => in_array($user->role_id, [1, 2]) ? Branch::all() : collect()
        ];
    }

}
