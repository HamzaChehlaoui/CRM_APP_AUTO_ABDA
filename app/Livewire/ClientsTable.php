<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice; // Make sure to import the Invoice model
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

    // --- NEW PROPERTIES FOR INVOICE VIEW ---
    /**
     * @var Client|null The currently selected client object to view invoices for.
     */
    public $selectedClient = null;

    /**
     * @var \Illuminate\Database\Eloquent\Collection The invoices of the selected client.
     */
    public $invoices;
    // --- END NEW PROPERTIES ---

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
        $this->invoices   = collect(); // Initialize as an empty collection
    }

    public function updatingSelectedBranch()
    {
        $this->resetPage();
    }

    // --- EXISTING EDIT/UPDATE METHODS (NO CHANGES NEEDED) ---
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

        $this->cancelEdit(); // Use the cancel method to reset state
        session()->flash('message', 'Client updated successfully.');
    }

    public function cancelEdit()
    {
        $this->clientData      = $this->defaultClientData;
        $this->editingClientId = null;
        $this->showEditModal   = false;
    }
    // --- END EXISTING METHODS ---


    // --- NEW METHODS FOR INVOICE VIEW ---
    /**
     * Sets the selected client and loads their invoices to switch the view.
     * This method is triggered when the user clicks the "View Invoices" button.
     *
     * @param int $clientId
     */
    public function showInvoices($clientId)
    {
        $this->selectedClient = Client::findOrFail($clientId);
        $this->invoices       = Invoice::where('client_id', $this->selectedClient->id)
                                       ->with('car') // Eager load related car data for performance
                                       ->latest()
                                       ->get();
    }

    /**
     * Resets the view back to the clients list.
     * This is triggered by the "Back" button in the invoice view.
     */
    public function showClientsList()
    {
        $this->selectedClient = null;
        $this->invoices       = collect(); // Clear the invoices
    }
    // --- END NEW METHODS ---

    public function render(DashboardService $dashboardService)
    {
        // The render method remains largely the same, but the view will handle the display logic.
        $user  = Auth::user();
        $data  = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $clients = $data['clientsQuery']
            ->with('cars') // Keep this for the client list view
            ->paginate(10);

        return view('livewire.clients-table', [
            'clients'        => $clients,
            'branches'       => $this->branches,
            'selectedBranch' => $this->selectedBranch,
            'stats'          => $this->stats,
        ]);
    }
}
