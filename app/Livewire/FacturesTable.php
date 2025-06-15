<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;
use FFI\Exception;
use Illuminate\Support\Facades\Hash;
USE Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class FacturesTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';
    public $branches = [];
    public $stats = [];
    public $search = '';
    public $statusFacture = 'all';
    public $statusApresVente = 'all';
    public $dateFrom;
    public $dateTo;
    public $dateErrorMessage;

    public $filteredInvoiceCount = 0;
    public $totalInvoiceCount = 0;

    protected $queryString = ['selectedBranch', 'statusFacture', 'statusApresVente', 'search', 'dateFrom', 'dateTo'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedBranch()
    {
        $this->resetPage();
    }

    public function updatingStatusFacture()
    {
        $this->resetPage();
    }

    public function updatingStatusApresVente()
    {
        $this->resetPage();
    }

    public function mount(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $this->branches = $data['branches'];
        $this->stats = $dashboardService->getDashboardStats($data['clientsQuery'], $data['suivisQuery'], $data['invoicesQuery']);
    }
public function deleteInvoice(Request $request)
{
    try {
        // Validation
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
            'password' => 'required|string'
        ]);

        // Vérifier le mot de passe
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mot de passe incorrect. Veuillez vérifier et réessayer.'
            ], 422);
        }

        // Supprimer la facture
        $invoice = Invoice::findOrFail($request->invoice_id);

        // (Optionnel) Vérifier si l'utilisateur a l'autorisation
        // if ($invoice->user_id !== auth()->id()) {
        //     return response()->json(['success' => false, 'message' => 'Vous n\'avez pas la permission de supprimer cette facture.'], 403);
        // }

        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Facture supprimée avec succès.'
        ]);

    } catch (ValidationException $e) {
        $errors = collect($e->errors())->flatten()->implode(' ');
        return response()->json([
            'success' => false,
            'message' => 'Des informations sont manquantes ou incorrectes. ' . $errors
        ], 422);
    } catch (Exception $e) {
        Log::error('Erreur lors de la suppression de la facture : ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Une erreur est survenue. Merci de réessayer plus tard ou de contacter l\'administrateur.'
        ], 500);
    }
}

    public function render(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $invoicesQuery = $data['invoicesQuery']->with(['client', 'car']);

        $totalQuery = clone $invoicesQuery;
        $this->totalInvoiceCount = $totalQuery->count();

        if (!empty($this->search)) {
            $invoicesQuery->where(function ($query) {
                $query
                    ->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('full_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('total_amount', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFacture !== 'all') {
            $invoicesQuery->where('statut_facture', $this->statusFacture);
        }

        if ($this->statusApresVente !== 'all') {
            $invoicesQuery->whereHas('car', function ($query) {
                $query->where('post_sale_status', $this->statusApresVente);
            });
        }
        $this->dateErrorMessage = null;
        if ($this->dateFrom && $this->dateTo && $this->dateFrom > $this->dateTo) {
            $this->dateErrorMessage = '⚠️ La date de début ne peut pas être postérieure à la date de fin.';
        } else {
            if ($this->dateFrom) {
                $invoicesQuery->whereDate('sale_date', '>=', $this->dateFrom);
            }

            if ($this->dateTo) {
                $invoicesQuery->whereDate('sale_date', '<=', $this->dateTo);
            }
        }

        $this->filteredInvoiceCount = $invoicesQuery->count();

        $invoices = $invoicesQuery->paginate(6);

        return view('livewire.factures-table', [
            'invoices' => $invoices,
            'branches' => $this->branches,
            'selectedBranch' => $this->selectedBranch,
            'stats' => $this->stats,
            'filteredInvoiceCount' => $this->filteredInvoiceCount,
            'totalInvoiceCount' => $this->totalInvoiceCount,
        ]);
    }





}
