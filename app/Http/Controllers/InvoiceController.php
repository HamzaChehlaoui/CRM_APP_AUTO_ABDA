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

            // dd($request);
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

    public function updateInvoice(Request $request, $id)
    {
        // Validation rules
        $validatedData = $request->validate(
            [
                // Car fields
                'car_brand' => 'nullable|string|max:100',
                'car_model' => 'nullable|string|max:100',
                'car_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'car_color' => 'nullable|string|max:50',
                'car_registration' => 'nullable|string|max:20',
                'car_ivn' => 'nullable|string|max:50',
                'car_chassis' => 'nullable|string|max:100',

                // Invoice fields
                'invoice_number' => 'required|string|max:50',
                'sale_date' => 'required|date',
                'statut_facture' => 'required|in:creation,facturé,envoyée_pour_paiement,paiement',
                'total_amount' => 'required|numeric|min:0',
                'accord_reference' => 'nullable|string|max:100',
                'purchase_order_number' => 'nullable|string|max:50',
                'delivery_note_number' => 'nullable|string|max:50',
                'payment_order_reference' => 'nullable|string|max:100',
            ],
            [
                // Custom error messages
                'invoice_number.required' => 'Le numéro de facture est obligatoire.',
                'sale_date.required' => 'La Date de Facture est obligatoire.',
                'statut_facture.required' => 'Le statut de la facture est obligatoire.',
                'total_amount.required' => 'Le montant TTC est obligatoire.',
                'total_amount.numeric' => 'Le montant TTC doit être un nombre.',
                'car_year.integer' => 'L\'année doit être un nombre entier.',
                'car_year.min' => 'L\'année doit être supérieure à 1900.',
                'car_year.max' => 'L\'année ne peut pas être dans le futur.',
            ],
        );

        try {
            // Start database transaction
            DB::beginTransaction();

            // Find the invoice with its car relationship
            $invoice = Invoice::with('car')->findOrFail($id);

            // Update invoice data
            $invoice->update([
                'invoice_number' => $validatedData['invoice_number'],
                'sale_date' => $validatedData['sale_date'],
                'statut_facture' => $validatedData['statut_facture'],
                'total_amount' => $validatedData['total_amount'],
                'accord_reference' => $validatedData['accord_reference'],
                'purchase_order_number' => $validatedData['purchase_order_number'],
                'delivery_note_number' => $validatedData['delivery_note_number'],
                'payment_order_reference' => $validatedData['payment_order_reference'],
            ]);

            // Update car data if car exists and car data is provided
            if ($invoice->car && ($validatedData['car_brand'] || $validatedData['car_model'])) {
                $invoice->car->update([
                    'brand' => $validatedData['car_brand'],
                    'model' => $validatedData['car_model'],
                    'year' => $validatedData['car_year'],
                    'color' => $validatedData['car_color'],
                    'registration_number' => $validatedData['car_registration'],
                    'ivn' => $validatedData['car_ivn'],
                    'chassis_number' => $validatedData['car_chassis'],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Les modifications ont été enregistrées avec succès.',
                    'invoice' => $invoice->fresh('car'),
                ]);
            }

            return redirect()->back()->with('success', 'Les modifications ont été enregistrées avec succès.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();

            // Log the error
            Log::error('Error updating invoice: ' . $e->getMessage(), [
                'invoice_id' => $id,
                'user_id' => auth()->id(),
                'data' => $validatedData,
            ]);

            // Return error response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.',
                    ],
                    500,
                );
            }

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.')->withInput();
        }
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
