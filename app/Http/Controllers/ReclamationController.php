<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Http\Requests\StoreReclamationRequest;
use App\Http\Requests\UpdateReclamationRequest;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = Reclamation::with('client', 'user')->paginate(10);
        return view('reclamations.index', compact('reclamations'));
    }

    public function create()
    {
        return view('reclamations.create');
    }

    public function store(StoreReclamationRequest $request)
    {
        Reclamation::create($request->validated());
        return redirect()->route('reclamations.index')->with('success', 'Reclamation created successfully.');
    }

    public function show(Reclamation $reclamation)
    {
        $reclamation->load('client', 'user');
        return view('reclamations.show', compact('reclamation'));
    }

    public function edit(Reclamation $reclamation)
    {
        return view('reclamations.edit', compact('reclamation'));
    }

    public function update(UpdateReclamationRequest $request, Reclamation $reclamation)
    {
        $reclamation->update($request->validated());
        return redirect()->route('reclamations.index')->with('success', 'Reclamation updated successfully.');
    }

    public function destroy(Reclamation $reclamation)
    {
        $reclamation->delete();
        return redirect()->route('reclamations.index')->with('success', 'Reclamation deleted successfully.');
    }
}
