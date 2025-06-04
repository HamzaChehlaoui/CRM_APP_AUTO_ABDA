<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use App\Services\DashboardService;

class InvoiceController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService)
{
    $user = auth()->user();
    $selectedBranch = $request->get('branch_filter', 'all');
    $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);
    $stats = $dashboardService->getDashboardStats(
        $data['clientsQuery'],
        $data['suivisQuery'],
        $data['invoicesQuery']
    );
    $clients = $data['clientsQuery']
    ->with('cars')
    ->get();

    return view('page.factures', array_merge($stats, [
        'branches' => $data['branches'],
        'selectedBranch' => $selectedBranch,
        'clients' =>$clients,
    ]));
}

    public function create()
    {
        return view('invoices.create');
    }

    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create($request->validated());
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'car', 'user', 'branch']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
