<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Suivi;
use App\Models\Invoice;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $user = auth()->user();
    $now = Carbon::now();
    $lastMonth = $now->copy()->subMonth();

    if ($user->role_id == 1 || $user->role_id == 2) {
        $clientsQuery = Client::query();
        $suivisQuery = Suivi::query();
        $invoicesQuery = Invoice::query();
    } else {
        $branchId = $user->branch_id;

        $clientsQuery = Client::where('branch_id', $branchId);
        $suivisQuery = Suivi::where('branch_id', $branchId);
        $invoicesQuery = Invoice::where('branch_id', $branchId);
    }

    $totalClientsCurrent = $clientsQuery->count();
    $suivisEnCoursCurrent = $suivisQuery->where('status', 'en_cours')->count();
    $activeClientsCurrent = $clientsQuery->whereHas('invoices')->count();
    $salesThisMonthCurrent = $invoicesQuery->whereMonth('sale_date', $now->month)
                                          ->whereYear('sale_date', $now->year)
                                          ->count();

    $totalClientsLast = $clientsQuery->whereMonth('created_at', $lastMonth->month)
                                    ->whereYear('created_at', $lastMonth->year)
                                    ->count();

    $suivisEnCoursLast = $suivisQuery->where('status', 'en_cours')
                                    ->whereMonth('created_at', $lastMonth->month)
                                    ->whereYear('created_at', $lastMonth->year)
                                    ->count();

    $activeClientsLast = $clientsQuery->whereHas('invoices', function($q) use ($lastMonth) {
        $q->whereMonth('sale_date', $lastMonth->month)
          ->whereYear('sale_date', $lastMonth->year);
    })->count();

    $salesThisMonthLast = $invoicesQuery->whereMonth('sale_date', $lastMonth->month)
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

    return view('page.dashboard', compact(
        'totalClientsCurrent',
        'suivisEnCoursCurrent',
        'activeClientsCurrent',
        'salesThisMonthCurrent',
        'percentageClients',
        'percentageSuivis',
        'percentageActive',
        'percentageSales'
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
