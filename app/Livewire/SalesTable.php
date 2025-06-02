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

    // Add these properties for the edit modal
    public $editingSuivi = null;
    public $editDateSuivi = '';
    public $editStatus = '';
    public $editNote = '';
    public $editClientName = '';

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

    public function deleteSuivi($suiviId)
    {
        try {
            $suivi = Suivi::find($suiviId);

            if ($suivi) {
                $suivi->delete();
                session()->flash('message', 'Suivi supprimé avec succès.');
            } else {
                session()->flash('error', 'Suivi non trouvé.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression du suivi.');
        }
    }

    public function editSuivi($suiviId)
    {
        try {
            $suivi = Suivi::with('client')->findOrFail($suiviId);

            $this->editingSuivi = $suiviId;
            $this->editDateSuivi = $suivi->date_suivi;
            $this->editStatus = $suivi->status;
            $this->editNote = $suivi->note;
            $this->editClientName = $suivi->client->full_name;

            // Dispatch browser event to show modal
            $this->dispatch('show-edit-modal');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement du suivi.');
        }
    }

    public function updateSuivi()
    {
        // Validate the input
        $this->validate([
            'editDateSuivi' => 'required|date',
            'editStatus' => 'required|string',
            'editNote' => 'nullable|string|max:1000',
        ]);

        try {
            $suivi = Suivi::findOrFail($this->editingSuivi);

            // Update the suivi with new data
            $suivi->update([
                'date_suivi' => $this->editDateSuivi,
                'status' => $this->editStatus,
                'note' => $this->editNote
            ]);

            // Reset the editing state
            $this->resetEditingState();

            // Dispatch browser event to hide modal
            $this->dispatch('hide-edit-modal');

            session()->flash('message', 'Suivi mis à jour avec succès!');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour du suivi.');
        }
    }

    public function cancelEdit()
    {
        $this->resetEditingState();
        $this->dispatch('hide-edit-modal');
    }

    private function resetEditingState()
    {
        $this->editingSuivi = null;
        $this->editDateSuivi = '';
        $this->editStatus = '';
        $this->editNote = '';
        $this->editClientName = '';
    }

    public function completeSuivi($suiviId)
    {
        try {
            $suivi = Suivi::findOrFail($suiviId);
            $suivi->update(['status' => 'Terminé']);

            session()->flash('message', 'Suivi marqué comme terminé!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour du suivi.');
        }
    }
}
