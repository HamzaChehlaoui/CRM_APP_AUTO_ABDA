<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Suivi;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $user = auth()->user();
    $now = Carbon::now();
    $lastMonth = $now->copy()->subMonth();

    // Get selected branch from request (for admin/assistant filter)
    $selectedBranch = $request->get('branch_filter', 'all');

    if ($user->role_id == 1 || $user->role_id == 2) {
        // Admin and Assistant - can filter by branch
        $clientsQuery = Client::query();
        $suivisQuery = Suivi::query();
        $invoicesQuery = Invoice::query();

        // Apply branch filter if not "all"
        if ($selectedBranch !== 'all') {
            $clientsQuery = $clientsQuery->where('branch_id', $selectedBranch);
            $suivisQuery = $suivisQuery->where('branch_id', $selectedBranch);
            $invoicesQuery = $invoicesQuery->where('branch_id', $selectedBranch);
        }

        // Get all branches for the filter dropdown
        $branches = Branch::all(); // Assuming you have a Branch model
    } else {
        // Regular users - restricted to their branch
        $branchId = $user->branch_id;
        $selectedBranch = $branchId; // Force to user's branch

        $clientsQuery = Client::where('branch_id', $branchId);
        $suivisQuery = Suivi::where('branch_id', $branchId);
        $invoicesQuery = Invoice::where('branch_id', $branchId);

        $branches = collect(); // Empty collection for non-admin users
    }

    // Current month statistics
    $totalClientsCurrent = $clientsQuery->count();
    $suivisEnCoursCurrent = $suivisQuery->where('status', 'en_cours')->count();
    $activeClientsCurrent = $clientsQuery->whereHas('invoices')->count();
    $salesThisMonthCurrent = $invoicesQuery->whereMonth('sale_date', $now->month)
                                        ->whereYear('sale_date', $now->year)
                                        ->count();

    // Last month statistics (need to clone queries to avoid conflicts)
    $totalClientsLast = (clone $clientsQuery)->whereMonth('created_at', $lastMonth->month)
                                    ->whereYear('created_at', $lastMonth->year)
                                    ->count();

    $suivisEnCoursLast = (clone $suivisQuery)->where('status', 'en_cours')
                                    ->whereMonth('created_at', $lastMonth->month)
                                    ->whereYear('created_at', $lastMonth->year)
                                    ->count();

    $activeClientsLast = (clone $clientsQuery)->whereHas('invoices', function($q) use ($lastMonth) {
        $q->whereMonth('sale_date', $lastMonth->month)
            ->whereYear('sale_date', $lastMonth->year);
    })->count();

    $salesThisMonthLast = (clone $invoicesQuery)->whereMonth('sale_date', $lastMonth->month)
                                        ->whereYear('sale_date', $lastMonth->year)
         ->count();

    $calcPercentageChange = function($current, $previous) {
        if ($previous == 0) return '0%';
        $change = (($current - $previous) / $previous) * 100;
        $sign = $change >= 0 ? '+' : '';
        return $sign . round($change) . '%';
    };

    $percentageClients = $calcPercentageChange($totalClientsCurrent, $totalClientsLast);
    $percentageSuivis = $calcPercentageChange($suivisEnCoursCurrent, $suivisEnCoursLast);
    $percentageActive = $calcPercentageChange($activeClientsCurrent, $activeClientsLast);
    $percentageSales = $calcPercentageChange($salesThisMonthCurrent, $salesThisMonthLast);
    $clientsVendus = [];

    $period = $request->get('period', 'week');

    $clientsVendus = [];

   if ($period === 'week') {
    foreach (range(0, 6) as $i) {
        $day = Carbon::now()->startOfWeek()->addDays($i);
        $count = (clone $invoicesQuery)
            ->whereDate('sale_date', $day)
            ->distinct('client_id')
            ->count('client_id');
        $clientsVendus[] = $count;
    }
    $labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

} elseif ($period === 'month') {
    foreach (range(1, Carbon::now()->daysInMonth) as $i) {
        $date = Carbon::now()->startOfMonth()->addDays($i - 1);
        $count = (clone $invoicesQuery)
            ->whereDate('sale_date', $date)
            ->distinct('client_id')
            ->count('client_id');
        $clientsVendus[] = $count;
        $labels[] = $date->day;
    }

} elseif ($period === 'year') {
    foreach (range(1, 12) as $i) {
        $start = Carbon::now()->startOfYear()->addMonths($i - 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $count = (clone $invoicesQuery)
            ->whereBetween('sale_date', [$start, $end])
            ->distinct('client_id')
            ->count('client_id');
        $clientsVendus[] = $count;
        $labels[] = $start->shortMonthName;
    }
}

    return view('page.dashboard', compact(
        'totalClientsCurrent',
        'suivisEnCoursCurrent',
        'activeClientsCurrent',
        'salesThisMonthCurrent',
        'percentageClients',
        'percentageSuivis',
        'percentageActive',
        'percentageSales',
        'branches',
        'selectedBranch',
        'clientsVendus',
        'labels'
    ));
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
