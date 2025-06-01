<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

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
            ->paginate(5);

        $clients = $data['clientsQuery'] ?? Client::where('branch_id', $data['branchId'])->get();

        return view('livewire.sales-table', [
            'suivis' => $suivis,
            'branches' => $data['branches'],
            'clients' => $clients,
        ]);
    }
}
