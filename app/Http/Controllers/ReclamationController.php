<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $user = auth()->user();

    $reclamationsQuery = Reclamation::with(['client', 'user', 'createdBy'])
        ->orderBy('created_at', 'desc');

    if ($user->role_id > 2) {
        $branchId = $user->branch_id;

        $reclamationsQuery->whereHas('client', function ($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        });

        $clients = Client::where('branch_id', $branchId)->orderBy('full_name')->get();
    } else {
        $clients = Client::orderBy('full_name')->get();
    }

    $reclamations = $reclamationsQuery->paginate(6);
    $users = User::orderBy('name')->get();

    return view('page.reclamations', compact('reclamations', 'clients', 'users'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:1000',
            'Priorite' => 'required|in:Basse,Moyenne,Haute',
            'user_id' => 'nullable|exists:users,id',
        ], [
            'client_id.required' => 'Veuillez sélectionner un client.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            'description.required' => 'La description est obligatoire.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
            'Priorite.required' => 'Veuillez sélectionner une priorité.',
            'Priorite.in' => 'La priorité sélectionnée n\'est pas valide.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $reclamation = Reclamation::create([
                'client_id' => $request->client_id,
                'user_id' => $request->user_id,
                'description' => $request->description,
                'Priorite' => $request->Priorite,
                'status' => 'nouvelle',
                'created_by' => Auth::id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Réclamation créée avec succès.',
                    'reclamation' => $reclamation->load(['client', 'user', 'createdBy'])
                ]);
            }

            return redirect()->route('reclamations.index')
                ->with('success', 'Réclamation créée avec succès.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la création de la réclamation.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de la réclamation.')
                ->withInput();
        }
    }



    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    try {
        $reclamation = Reclamation::findOrFail($id);

        $validatedData = $request->validate([
            'description' => 'required|string',
            'Priorite' => 'required|in:Basse,Moyenne,Haute',
            'status' => 'required|in:nouvelle,en_cours,résolue',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        $reclamation->update($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Réclamation mise à jour avec succès!'
            ]);
        }

        return redirect()->route('reclamations.index')
                        ->with('success', 'Réclamation mise à jour avec succès!');

    } catch (\Exception $e) {
        if ($request->ajax()) {

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }

        return redirect()->back()
                        ->with('error', 'Erreur lors de la mise à jour de la réclamation');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reclamation $reclamation)
    {
        try {
            $reclamation->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Réclamation supprimée avec succès.'
                ]);
            }

            return redirect()->route('reclamations.index')
                ->with('success', 'Réclamation supprimée avec succès.');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la suppression.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }


}
