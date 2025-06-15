<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';
    public $branches = [];
    public $stats = [];

    public $editingClientId = null;
    public $clientData = [];
    public $defaultClientData = [
        'full_name' => '',
        'email'     => '',
        'phone'     => '',
        'address'   => '',
        'cin'       => '',
    ];
    public $showEditModal = false;

    // --- تعديل هنا ---
    public $selectedClientId = null;
    // --- نهاية التعديل ---

    protected $queryString = ['selectedBranch'];
    protected $paginationTheme = 'tailwind';

    public function mount(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $this->branches = $data['branches'];
        $this->stats    = $dashboardService->getDashboardStats(
            $data['clientsQuery'],
            $data['suivisQuery'],
            $data['invoicesQuery']
        );

        $this->clientData = $this->defaultClientData;
    }

    public function updatingSelectedBranch()
    {
        $this->resetPage();
    }

    public function editClient($clientId)
    {
        $client                = Client::findOrFail($clientId);
        $this->editingClientId = $client->id;
        $this->clientData      = [
            'full_name' => $client->full_name,
            'email'     => $client->email,
            'phone'     => $client->phone,
            'address'   => $client->address,
            'cin'       => $client->cin,
        ];
        $this->showEditModal   = true;
    }

    public function updateClient()
    {
        $this->validate([
            'clientData.full_name' => 'required|string|max:255',
            'clientData.email'     => 'nullable|email|max:255',
            'clientData.phone'     => 'nullable|string|max:20',
            'clientData.address'   => 'nullable|string|max:255',
            'clientData.cin'       => 'nullable|string|max:50',
        ]);

        $client = Client::findOrFail($this->editingClientId);
        $client->update($this->clientData);

        $this->cancelEdit();
        session()->flash('message', 'Client updated successfully.');
    }

    public function cancelEdit()
    {
        $this->clientData      = $this->defaultClientData;
        $this->editingClientId = null;
        $this->showEditModal   = false;
    }

    // عرض فواتير عميل معيّن
    public function showInvoices($clientId)
    {
        $this->resetPage();
        $this->selectedClientId = $clientId;
    }

    public function showClientsList()
    {
        $this->selectedClientId = null;
    }

    public function render(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        if ($this->selectedClientId) {
            $selectedClient = Client::find($this->selectedClientId);
            $invoices = Invoice::where('client_id', $this->selectedClientId)
                                ->with('car')
                                ->latest()
                                ->paginate(6);

            return view('livewire.clients-table', [
                'selectedClient' => $selectedClient,
                'invoices'       => $invoices,
                'clients'        => collect(),
            ]);
        }

        $clients = $data['clientsQuery']
            ->with('cars')
            ->paginate(10);

        return view('livewire.clients-table', [
            'clients'        => $clients,
            'branches'       => $this->branches,
            'selectedBranch' => $this->selectedBranch,
            'stats'          => $this->stats,
            'selectedClient' => null,
            'invoices'       => null,
        ]);
    }
}
