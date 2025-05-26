<?php

namespace App\Http\Controllers;

use App\Models\Entretien;
use App\Http\Requests\StoreEntretienRequest;
use App\Http\Requests\UpdateEntretienRequest;

class EntretienController extends Controller
{
    public function index()
    {
        $entretiens = Entretien::with('client', 'user')->paginate(10);
        return view('entretiens.index', compact('entretiens'));
    }

    public function create()
    {
        return view('entretiens.create');
    }

    public function store(StoreEntretienRequest $request)
    {
        Entretien::create($request->validated());
        return redirect()->route('entretiens.index')->with('success', 'Entretien created successfully.');
    }

    public function show(Entretien $entretien)
    {
        $entretien->load('client', 'user');
        return view('entretiens.show', compact('entretien'));
    }

    public function edit(Entretien $entretien)
    {
        return view('entretiens.edit', compact('entretien'));
    }

    public function update(UpdateEntretienRequest $request, Entretien $entretien)
    {
        $entretien->update($request->validated());
        return redirect()->route('entretiens.index')->with('success', 'Entretien updated successfully.');
    }

    public function destroy(Entretien $entretien)
    {
        $entretien->delete();
        return redirect()->route('entretiens.index')->with('success', 'Entretien deleted successfully.');
    }
}
