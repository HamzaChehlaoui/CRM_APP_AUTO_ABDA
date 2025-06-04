<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
{
    return [
        'client_id' => 'required|exists:clients,id',
        'car.brand' => 'required|string|max:255',
        'car.model' => 'required|string|max:255',
        'car.ivn' => 'required|string|max:255|unique:cars,ivn',
        'car.registration_number' => 'required|string|max:255|unique:cars,registration_number',
        'car.chassis_number' => 'required|string|max:255|unique:cars,chassis_number',
        'car.color' => 'nullable|string|max:255',
        'car.year' => 'nullable|integer|min:1900|max:2099',
        'car.post_sale_status' => 'required|in:en_attente_livraison,livre,sav_1ere_visite,relance',
        'invoice.invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
        'invoice.sale_date' => 'required|date',
        'invoice.total_amount' => 'required|numeric|min:0',
        'invoice.accord_reference' => 'nullable|string|max:255',
        'invoice.purchase_order_number' => 'nullable|string|max:255',
        'invoice.delivery_note_number' => 'nullable|string|max:255',
        'invoice.payment_order_reference' => 'nullable|string|max:255',
        'invoice.image' => 'nullable|image|mimes:png,jpg,jpeg|max:10240', // 10MB max
    ];
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
