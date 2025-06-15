<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsService
{
    /**
     * Get general statistics (total clients, sales, revenue, active suivis).
     */
    public function getGeneralStatistics(string $startDate, string $endDate, Builder $clientsQuery, Builder $invoicesQuery, Builder $suivisQuery): array
    {
        // Fix dates to ensure accuracy and cover the entire last day
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        return [
            'totalClients' => (clone $clientsQuery)->whereBetween('created_at', [$start, $end])->count(),
            'totalSales' => (clone $invoicesQuery)->whereBetween('sale_date', [$start, $end])->count(),
            'totalRevenue' => (clone $invoicesQuery)->whereBetween('sale_date', [$start, $end])->sum('total_amount'),
            'activeSuivis' => (clone $suivisQuery)->where('status', 'en_cours')
                ->whereBetween('date_suivi', [$start, $end])
                ->count(),
        ];
    }

    /**
     * Get sales by car model.
     */
    public function getInvoiceStats(string $startDate, string $endDate, Builder $invoicesQuery)
{
    $start = Carbon::parse($startDate)->startOfDay();
    $end   = Carbon::parse($endDate)->endOfDay();

    $data = $invoicesQuery
        ->whereBetween('sale_date', [$start, $end])
        ->select(
            DB::raw('COUNT(id) as total_invoices'),
            DB::raw('SUM(total_amount) as total_amount'),
            DB::raw("SUM(CASE WHEN statut_facture = 'creation' THEN 1 ELSE 0 END) as count_creation"),
            DB::raw("SUM(CASE WHEN statut_facture = 'facturé' THEN 1 ELSE 0 END) as count_facturé"),
            DB::raw("SUM(CASE WHEN statut_facture = 'envoyée_pour_paiement' THEN 1 ELSE 0 END) as count_envoyée"),
            DB::raw("SUM(CASE WHEN statut_facture = 'paiement' THEN 1 ELSE 0 END) as count_paiement")
        )
        ->first();

    return [
        'total_invoices' => (int) $data->total_invoices,
        'total_amount' => (float) $data->total_amount,
        'statut_breakdown' => [
            'creation' => (int) $data->count_creation,
            'facturé' => (int) $data->count_facturé,
            'envoyée_pour_paiement' => (int) $data->count_envoyée,
            'paiement' => (int) $data->count_paiement,
        ],
    ];
}


    /**
     * Get customer satisfaction data.
     */
    public function getSatisfactionData(string $startDate, string $endDate, Builder $suivisQuery): ?array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        $totalSuivis = (clone $suivisQuery)->whereBetween('date_suivi', [$start, $end])->count();

        // If there are no suivis, return null to indicate no data
        if ($totalSuivis == 0) {
            return null;
        }

        $completedSuivis = (clone $suivisQuery)->where('status', 'termine')->whereBetween('date_suivi', [$start, $end])->count();

        $categories = ['accueil' => 5, 'conseil' => -2, 'prix' => -8, 'service' => 3, 'suivi' => -1];
        $baseScore = ($completedSuivis / $totalSuivis) * 100;

        $result = [];
        foreach ($categories as $category => $variation) {
            $score = round($baseScore + $variation);
            $result[$category] = min(100, max(50, $score)); // Ensure score is between 50 and 100
        }
        return $result;
    }

    /**
     * Get the top performing employees.
     */
    public function getTopPerformers(string $startDate, string $endDate, Builder $usersQuery)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        $users = $usersQuery
            ->withCount([
                'clients as prospects_count',
                'invoices as sales_count' => function ($query) use ($start, $end) {
                    $query->whereBetween('sale_date', [$start, $end]);
                },
                'suivis as total_suivis_count' => function ($query) use ($start, $end) {
                    $query->whereBetween('date_suivi', [$start, $end]);
                },
                'suivis as completed_suivis_count' => function ($query) use ($start, $end) {
                    $query->where('status', 'termine')->whereBetween('date_suivi', [$start, $end]);
                }
            ])
            ->whereHas('invoices', function ($query) use ($start, $end) {
                $query->whereBetween('sale_date', [$start, $end]);
            })
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        return $users->map(function ($user) {
            $conversionRate = $user->prospects_count > 0
                ? round(($user->sales_count / $user->prospects_count) * 100, 1)
                : 0;

            // CHANGED: Using 0 instead of a random value for accurate representation
            $satisfactionRate = $user->total_suivis_count > 0
                ? round(($user->completed_suivis_count / $user->total_suivis_count) * 100, 1)
                : 0;

            return [
                'name' => $user->name,
                'initials' => $this->getInitials($user->name),
                'prospects' => $user->prospects_count,
                'sales' => $user->sales_count,
                'conversion_rate' => $conversionRate,
                'satisfaction_rate' => $satisfactionRate,
                'performance_label' => $this->getPerformanceLabel($conversionRate, $satisfactionRate)
            ];
        });
    }

    /**
     * Helper function to get initials from a name.
     */
    private function getInitials(string $name): string
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

    /**
     * Helper function to get a performance label based on scores.
     */
    private function getPerformanceLabel(float $conversionRate, float $satisfactionRate): string
    {
        $averageScore = ($conversionRate + $satisfactionRate) / 2;

        if ($averageScore >= 80) return 'Excellente';
        if ($averageScore >= 65) return 'Très bonne';
        if ($averageScore >= 50) return 'Bonne';
        if ($averageScore >= 35) return 'Moyenne';
        return 'À améliorer';
    }
}
