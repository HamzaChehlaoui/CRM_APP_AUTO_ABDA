<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Suivi;
use App\Models\Invoice;
use App\Models\Branch;
use App\Services\DashboardService;

class SalesTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';

    public function updatedSelectedBranch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $dashboardService = app(DashboardService::class);

        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $suivis = $data['suivisQuery']
            ->with('client.branch', 'user')
            ->orderBy('date_suivi', 'desc')
            ->paginate(5);

        $clients = $data['clientsQuery']->get();

        return view('livewire.sales-table', [
            'suivis' => $suivis,
            'branches' => $data['branches'],
            'clients' => $clients,
        ]);
    }
}
