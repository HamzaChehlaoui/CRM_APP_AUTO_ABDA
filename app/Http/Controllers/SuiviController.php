<?php

namespace App\Http\Controllers;
use App\Models\Suivi;
use App\Http\Requests\StoreSuiviRequest;
use App\Http\Requests\UpdateSuiviRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Models\Client;

class SuiviController extends Controller
{
public function index(Request $request ,DashboardService $dashboardService)
{
    $selectedBranch = $request->input('branch', 'all');
    $user = auth()->user();

    $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);



$clients = ($data['clientsQuery'] ?? Client::where('branch_id', $data['branchId']))->get();
return view('page.suivis', [
    'branches' => $data['branches'],
    'selectedBranch' => $selectedBranch,
    'clients' => $clients // Add this
]);
}



    public function create()
    {
        return view('suivis.create');
    }

    public function store(StoreSuiviRequest $request)
{
    $data = $request->validated();
    $data['created_by'] = auth()->id(); // Add this if you want to track who created it

    Suivi::create($data);
    return redirect()->route('page.suivis')->with('success', 'Suivi created successfully.');
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
