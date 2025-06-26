<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService)
    {
        $user = auth()->user();
        $selectedBranch = $request->get('branch_filter', 'all');
        $data = $dashboardService->resolveBranchInfo($user, $selectedBranch);
        $stats = $dashboardService->getDashboardStats($data['clientsQuery'], $data['suivisQuery'], $data['invoicesQuery']);
        $clients = $data['clientsQuery']->with('cars')->get();

        return view(
            'page.factures',
            array_merge($stats, [
                'branches' => $data['branches'],
                'selectedBranch' => $selectedBranch,
                'clients' => $clients,
            ]),
        );
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function storeAll(StoreInvoiceRequest $request)
    {
        $action = $request->input('action');
        $statut = $action === 'facturer' ? 'facturé' : 'creation';
        if ($action === 'save') {
        DB::beginTransaction();
        try {

            $carData = $request->input('car', []);
            $car = Car::create([
                'brand' => $carData['brand'] ?? null,
                'model' => $carData['model'] ?? null,
                'ivn' => $carData['ivn'] ?? null,
                'registration_number' => $carData['registration_number'] ?? null,
                'chassis_number' => $carData['chassis_number'] ?? null,
                'color' => $carData['color'] ?? null,
                'year' => $carData['year'] ?? null,
                'client_id' => $request->input('client_id'),

                'branch_id' => auth()->user()->branch_id,
                'created_by' => auth()->id(),
            ]);
            $invoiceData = $request->input('invoice', []);
            $invoice = Invoice::create([
                'invoice_number' => $invoiceData['invoice_number'] ?? null,
                'sale_date' => $invoiceData['sale_date'] ?? null,
                'total_amount' => $invoiceData['total_amount'] ?? null,
                'accord_reference' => $invoiceData['purchase_order_number'] ?? null,
                'purchase_order_number' => $invoiceData['purchase_order_number'] ?? null,
                'delivery_note_number' => $invoiceData['delivery_note_number'] ?? null,
                'payment_order_reference' => $invoiceData['payment_order_reference'] ?? null,
                'statut_facture' => 'creation',
                'client_id' =>$request->input('client_id'),
                'car_id' => $car->id,
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
            ]);

            // Sauvegarder les images si elles existent
            if ($request->hasFile('image_invoice')) {
                $invoice->image_path = $request->file('image_invoice')->store('invoices', 'public');
            }

            if ($request->hasFile('image_bl')) {
                $invoice->image_bl = $request->file('image_bl')->store('bons_livraison', 'public');
            }

            if ($request->hasFile('image_or')) {
                $invoice->image_or = $request->file('image_or')->store('ordres_reparation', 'public');
            }

            if ($request->hasFile('image_bc')) {
                $invoice->image_bc = $request->file('image_bc')->store('bons_commande', 'public');
            }

            $invoice->save(); // enregistrer les chemins d'image

            DB::commit();
            return redirect()->route('invoice.index')->with('success', 'Facture sauvegardée en mode CREATION.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in storeAll (save): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Erreur lors de la sauvegarde.')->withInput();
        }
        }

        $validated = $request->validated();
        Log::info('Validated data:', $validated);
        DB::beginTransaction();
        try {
            // Retrieve existing client
            $client = Client::findOrFail($validated['client_id']);
            Log::info('Client retrieved successfully', ['client_id' => $client->id]);

            // Create car
            $car = Car::create([
                'brand' => $validated['car']['brand'],
                'model' => $validated['car']['model'],
                'ivn' => $validated['car']['ivn'],
                'registration_number' => $validated['car']['registration_number'],
                'chassis_number' => $validated['car']['chassis_number'],
                'color' => $validated['car']['color'] ?? null,
                'year' => $validated['car']['year'] ?? null,
                'client_id' => $client->id,
                'branch_id' => $client->branch_id,
                'created_by' => auth()->id(),
            ]);

            if (!$car || !$car->id) {
                Log::error('Car creation failed', ['car' => $car]);
                throw new \Exception('Échec de la création de la voiture.');
            }

            // Prepare invoice data
            $invoiceData = [
                'invoice_number' => $validated['invoice']['invoice_number'],
                'sale_date' => $validated['invoice']['sale_date'],
                'total_amount' => $validated['invoice']['total_amount'],
                'accord_reference' => $validated['invoice']['purchase_order_number'] ?? null,
                'purchase_order_number' => $validated['invoice']['purchase_order_number'] ?? null,
                'delivery_note_number' => $validated['invoice']['delivery_note_number'] ?? null,
                'payment_order_reference' => $validated['invoice']['payment_order_reference'] ?? null,
                'statut_facture' => $statut,
                'client_id' => $client->id,
                'car_id' => $car->id,
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
            ];

            if ($request->hasFile('image_invoice')) {
                $invoiceData['image_path'] = $request->file('image_invoice')->store('invoices', 'public');
            }

            if ($request->hasFile('image_bl')) {
                $invoiceData['image_bl'] = $request->file('image_bl')->store('bons_livraison', 'public');
            }

            if ($request->hasFile('image_or')) {
                $invoiceData['image_or'] = $request->file('image_or')->store('ordres_reparation', 'public');
            }

            if ($request->hasFile('image_bc')) {
                $invoiceData['image_bc'] = $request->file('image_bc')->store('bons_commande', 'public');
            }

            // Create invoice
            $invoice = Invoice::create($invoiceData);

            // Create notification for the user who created the invoice
            \App\Http\Controllers\NotificationController::createNotification(auth()->id(), 'Nouvelle facture créée', 'La facture #' . $invoice->invoice_number . ' a été créée avec succès pour le client ' . $client->full_name . '.', 'invoice', auth()->id(), [
                'invoice_id' => $invoice->id,
                'client_id' => $client->id,
                'car_id' => $car->id,
            ]);

            DB::commit();

            return redirect()->route('invoice.index')->with('success', 'Voiture et facture enregistrées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in storeAll: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()
                ->withErrors(['error' => 'Erreur lors de l’enregistrement : ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function edit(Invoice $invoice)
    {
        $userBranchId = Auth::user()->branch_id;

        $clients = Client::where('branch_id', $userBranchId)
            ->orderBy('full_name')
            ->get();

        return view('page.edit_invoice_modal', compact('invoice', 'clients'));
    }



    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
{
    DB::beginTransaction();

    try {

        $action = $request->input('action');
        $invoice->statut_facture = $action === 'facture' ? 'facturé' : 'creation';

        $invoice->client_id = $request->client_id;
        $invoice->fill($request->input('invoice', []));

        foreach (['image_path', 'image_bc', 'image_bl', 'image_or'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('invoices/images', 'public');
                $invoice->$field = $path;
            }
        }

        $invoice->save();

        $carData = $request->input('car', []);

        if ($invoice->car) {
            $invoice->car->update($carData);
        } elseif (!empty($carData)) {
            $car = $invoice->car()->create($carData); // Créer la voiture si elle n’existe pas
        }

        DB::commit();

        return redirect()->route('invoice.index')->with('message', 'Facture mise à jour avec succès.');
    } catch (\Throwable $e) {

        DB::rollBack();
        report($e);

        return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour de la facture.');
    }
}

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
