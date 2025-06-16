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
        $reclamations = Reclamation::with(['client', 'user', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            
        $clients = Client::orderBy('full_name')->get();
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
     * Display the specified resource.
     */
    public function show(Reclamation $reclamation)
    {
        $reclamation->load(['client', 'user', 'createdBy']);
        return view('reclamations.show', compact('reclamation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reclamation $reclamation)
    {
        $clients = Client::orderBy('full_name')->get();
        $users = User::orderBy('name')->get();

        return view('reclamations.edit', compact('reclamation', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reclamation $reclamation)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:1000',
            'Priorite' => 'required|in:Basse,Moyenne,Haute',
            'status' => 'required|in:nouvelle,en_cours,résolue',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $reclamation->update([
                'client_id' => $request->client_id,
                'user_id' => $request->user_id,
                'description' => $request->description,
                'Priorite' => $request->Priorite,
                'status' => $request->status,
            ]);

            return redirect()->route('reclamations.index')
                ->with('success', 'Réclamation mise à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.')
                ->withInput();
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

    /**
     * Get reclamations by status for filtering
     */
    public function filterByStatus($status)
    {
        $validStatuses = ['nouvelle', 'en_cours', 'résolue'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->route('reclamations.index');
        }

        $reclamations = Reclamation::with(['client', 'user', 'createdBy'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        $clients = Client::orderBy('full_name')->get();
        $users = User::orderBy('name')->get();

        return view('reclamations.index', compact('reclamations', 'clients', 'users'));
    }
}
