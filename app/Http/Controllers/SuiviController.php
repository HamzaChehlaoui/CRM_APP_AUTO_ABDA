<?php

namespace App\Http\Controllers;

use App\Models\Suivi;
use App\Http\Requests\StoreSuiviRequest;
use App\Http\Requests\UpdateSuiviRequest;

class SuiviController extends Controller
{
    public function index()
    {
        $suivis = Suivi::with('client', 'user')->paginate(10);
        return view('suivis.index', compact('suivis'));
    }

    public function create()
    {
        return view('suivis.create');
    }

    public function store(StoreSuiviRequest $request)
    {
        Suivi::create($request->validated());
        return redirect()->route('suivis.index')->with('success', 'Suivi created successfully.');
    }

    public function show(Suivi $suivi)
    {
        $suivi->load('client', 'user');
        return view('suivis.show', compact('suivi'));
    }

    public function edit(Suivi $suivi)
    {
        return view('suivis.edit', compact('suivi'));
    }

    public function update(UpdateSuiviRequest $request, Suivi $suivi)
    {
        $suivi->update($request->validated());
        return redirect()->route('suivis.index')->with('success', 'Suivi updated successfully.');
    }

    public function destroy(Suivi $suivi)
    {
        $suivi->delete();
        return redirect()->route('suivis.index')->with('success', 'Suivi deleted successfully.');
    }
}
