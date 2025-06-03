<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'client.full_name' => 'required|string|max:255',
            'client.phone' => 'required|string|max:20',
            'client.cin' => 'required|string|max:100|unique:clients,cin',
            'client.email' => 'nullable|email|max:255',
            'client.address' => 'nullable|string|max:255',
            'client.branch_id' => 'required|exists:branches,id',

            'car.brand' => 'required|string|max:100',
            'car.model' => 'required|string|max:100',
            'car.ivn' => 'required|string|max:100|unique:cars,ivn',
            'car.registration_number' => 'required|string|max:100|unique:cars,registration_number',
            'car.chassis_number' => 'required|string|max:100|unique:cars,chassis_number',
            'car.color' => 'nullable|string|max:50',
            'car.year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),

            'invoice.invoice_number' => 'required|string|max:100|unique:invoices,invoice_number',
            'invoice.sale_date' => 'required|date',
            'invoice.total_amount' => 'required|numeric|min:0',
            'invoice.accord_reference' => 'nullable|string|max:255',
            'invoice.purchase_order_number' => 'nullable|string|max:255',
            'invoice.delivery_note_number' => 'nullable|string|max:255',
            'invoice.payment_order_reference' => 'nullable|string|max:255',
        ];
    }
    public function messages()
{
    return [
        'client.full_name.required' => 'Le nom complet est obligatoire.',
        'client.phone.required' => 'Le numéro de téléphone est obligatoire.',
        'client.cin.required' => "La carte d'identité nationale est obligatoire.",
        'client.cin.unique' => "La carte d'identité nationale est déjà enregistrée.",
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
    ];
}


}
