<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Suivi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsService
{
    public function getSalesByModel($startDate, $endDate)
    {
        return Invoice::select('cars.brand', 'cars.model', DB::raw('count(*) as total_sales'))
            ->join('cars', 'invoices.car_id', '=', 'cars.id')
            ->whereBetween('invoices.sale_date', [$startDate, $endDate])
            ->groupBy('cars.brand', 'cars.model')
            ->orderBy('total_sales', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->brand . ' ' . $item->model,
                    'sales' => $item->total_sales
                ];
            });
    }

    public function getSatisfactionData($startDate, $endDate)
    {
        $categories = ['accueil' => 5, 'conseil' => -2, 'prix' => -8, 'service' => 3, 'suivi' => -1];
        $completedSuivis = Suivi::where('status', 'termine')->whereBetween('date_suivi', [$startDate, $endDate])->count();
        $totalSuivis = Suivi::whereBetween('date_suivi', [$startDate, $endDate])->count();

        if ($totalSuivis == 0) {
            return array_fill_keys(array_keys($categories), 80);
        }

        $baseScore = ($completedSuivis / $totalSuivis) * 100;

        $result = [];
        foreach ($categories as $category => $variation) {
            $score = round($baseScore + $variation);
            $result[$category] = min(100, max(50, $score));
        }
        return $result;
    }

    public function getTopPerformers($startDate, $endDate)
    {
        $users = User::select('users.*')
            ->withCount([
                'clients as prospects_count',
                'invoices as sales_count' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('sale_date', [$startDate, $endDate]);
                }
            ])
            ->whereHas('invoices', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('sale_date', [$startDate, $endDate]);
            })
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        return $users->map(function ($user) use ($startDate, $endDate) {
            $userSuivis = Suivi::whereHas('client', function ($query) use ($user) {
                $query->where('created_by', $user->id);
            })
            ->whereBetween('date_suivi', [$startDate, $endDate])
            ->get();

            $conversionRate = $user->prospects_count > 0
                ? round(($user->sales_count / $user->prospects_count) * 100, 1)
                : 0;

            $completedSuivis = $userSuivis->where('status', 'termine')->count();
            $totalSuivis = $userSuivis->count();
            $satisfactionRate = $totalSuivis > 0
                ? round(($completedSuivis / $totalSuivis) * 100, 1)
                : rand(75, 95);

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

    public function getGeneralStatistics($startDate, $endDate)
    {
        return [
            'totalClients' => Client::whereBetween('created_at', [$startDate, $endDate])->count(),
            'totalSales' => Invoice::whereBetween('sale_date', [$startDate, $endDate])->count(),
            'totalRevenue' => Invoice::whereBetween('sale_date', [$startDate, $endDate])->sum('total_amount'),
            'activeSuivis' => Suivi::where('status', 'en_cours')
                ->whereBetween('date_suivi', [$startDate, $endDate])
                ->count(),
        ];
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
}
