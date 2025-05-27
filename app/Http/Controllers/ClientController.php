<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('branch')->paginate(10);
        return view('clients.index', compact('clients'));
    }
    public function postSaleStats()
{
    return response()->json([
        'en_attente_livraison' => Client::where('post_sale_status', 'en_attente_livraison')->count(),
        'livre' => Client::where('post_sale_status', 'livre')->count(),
        'sav_1ere_visite' => Client::where('post_sale_status', 'sav_1ere_visite')->count(),
        'relance' => Client::where('post_sale_status', 'relance')->count(),
    ]);
}
    public function create()
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated() + ['created_by' => auth()->id()]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load(['invoices', 'suivis', 'reclamations', 'entretiens']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
