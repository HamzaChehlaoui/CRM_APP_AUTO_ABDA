<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Car;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Suivi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StatisticsExport;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $salesByModel = $this->statisticsService->getSalesByModel($startDate, $endDate);
        $satisfactionData = $this->statisticsService->getSatisfactionData($startDate, $endDate);
        $topPerformers = $this->statisticsService->getTopPerformers($startDate, $endDate);
        $generalStats = $this->statisticsService->getGeneralStatistics($startDate, $endDate);

        return view('page.statistiques', array_merge(
            compact('salesByModel', 'satisfactionData', 'topPerformers', 'startDate', 'endDate'),
            $generalStats
        ));
    }

    private function calculateSatisfactionScore($category, $startDate, $endDate)
    {
        // This is a simplified calculation - you might want to implement
        // a more sophisticated satisfaction scoring system
        $completedSuivis = Suivi::where('status', 'termine')
            ->whereBetween('date_suivi', [$startDate, $endDate])
            ->count();

        $totalSuivis = Suivi::whereBetween('date_suivi', [$startDate, $endDate])->count();

        if ($totalSuivis == 0) return 80; // Default score

        $baseScore = ($completedSuivis / $totalSuivis) * 100;

        // Add some variation based on category
        $variations = [
            'accueil' => 5,
            'conseil' => -2,
            'prix' => -8,
            'service' => 3,
            'suivi' => -1
        ];

        return min(100, max(50, round($baseScore + ($variations[$category] ?? 0))));
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }

    private function getPerformanceLabel($conversionRate, $satisfactionRate)
    {
        $averageScore = ($conversionRate + $satisfactionRate) / 2;

        if ($averageScore >= 80) return 'Excellente';
        if ($averageScore >= 65) return 'Très bonne';
        if ($averageScore >= 50) return 'Bonne';
        if ($averageScore >= 35) return 'Moyenne';
        return 'À améliorer';
    }
    public function export(Request $request)
    {
        // Validate and parse dates
        $startDate = Carbon::parse($request->get('start_date', Carbon::now()->startOfMonth()))->startOfDay();
        $endDate = Carbon::parse($request->get('end_date', Carbon::now()->endOfMonth()))->endOfDay();

        // Validate date range
        if ($startDate->gt($endDate)) {
            return response()->json(['error' => 'Start date cannot be after end date'], 400);
        }

        // Get all statistics data
        $statistics = [
            'period' => $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'),
            'total_clients' => Client::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_sales' => Invoice::whereBetween('sale_date', [$startDate, $endDate])->count(),
            'total_revenue' => Invoice::whereBetween('sale_date', [$startDate, $endDate])->sum('total_amount') ?? 0,
            'active_suivis' => Suivi::where('status', 'en_cours')
                ->whereBetween('date_suivi', [$startDate, $endDate])
                ->count(),
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // Determine export format from request
        $format = $request->get('format', 'excel'); // Default to excel

        try {
            switch ($format) {
                case 'excel':
                    return Excel::download(new StatisticsExport($statistics),
                        'statistics_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.xlsx');

                case 'csv':
                    return Excel::download(new StatisticsExport($statistics),
                        'statistics_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv');

                case 'pdf':
                    $pdf = PDF::loadView('page.statistiques', compact('statistics'));
                    return $pdf->download('statistics_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.pdf');

                case 'json':
                default:
                    return response()->json($statistics);
            }
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            return response()->json(['error' => 'Export failed. Please try again.'], 500);
        }
    }
}
