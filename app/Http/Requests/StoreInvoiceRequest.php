<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize() { return true; }
 public function rules()
{
    $action = $this->input('action');

    if ($action === 'facturer') {

        return [
            'client_id' => 'required|exists:clients,id',

            // Informations voiture
            'car.brand' => 'required|string|max:255',
            'car.model' => 'required|string|max:255',
            'car.ivn' => 'required|string|max:255|unique:cars,ivn',
            'car.registration_number' => 'required|string|max:255|unique:cars,registration_number',
            'car.chassis_number' => 'required|string|max:255|unique:cars,chassis_number',
            'color' => 'nullable|string|max:50',
            'year' => 'nullable|digits:4|integer|min:1900|max:',
            // Informations facture
            'invoice.invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'invoice.sale_date' => 'required|date',
            'invoice.total_amount' => 'required|numeric|min:0',
            'invoice.purchase_order_number' => 'required|string|max:255',
            'invoice.delivery_note_number' => 'required|string|max:255',
            'invoice.payment_order_reference' => 'required|string|max:255',

            // Images (optionnelles ici, ajouter validation si obligatoires)
            'image_invoice' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'image_bl' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'image_or' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'image_bc' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ];
    }
    // Si le bouton est "save" (Enregistrer) : aucune validation requise
    return [];
}




    public function messages()
    {
        return [
            'car.brand.required' => 'La marque est obligatoire.',
            'car.model.required' => 'Le modèle est obligatoire.',
            'car.ivn.required' => 'L’identifiant véhicule neuf (IVN) est obligatoire.',
            'car.ivn.unique' => 'L’IVN est déjà enregistré.',
            'car.registration_number.required' => "Le numéro d'immatriculation est obligatoire.",
            'car.registration_number.unique' => "Le numéro d'immatriculation est déjà enregistré.",
            'car.chassis_number.required' => 'Le numéro de châssis est obligatoire.',
            'car.chassis_number.unique' => 'Le numéro de châssis est déjà enregistré.',
            'invoice.invoice_number.required' => 'Le numéro de facture est obligatoire.',
            'invoice.invoice_number.unique' => 'Le numéro de facture est déjà enregistré.',
            'invoice.sale_date.required' => 'La date de la facture est obligatoire.',
            'invoice.total_amount.required' => 'Le montant total est obligatoire.',
            'invoice.total_amount.numeric' => 'Le montant total doit être un nombre.',
            'invoice.image.image' => 'Le fichier doit être une image.',
            'invoice.image.mimes' => 'L’image doit être au format PNG, JPG ou JPEG.',
            'invoice.image.max' => 'L’image ne doit pas dépasser 10MB.',
        ];
    }
}
