<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $action = $this->input('action');
        $invoiceId = $this->route('invoice') ? $this->route('invoice')->id : null;
        $carId = $this->route('invoice') && $this->route('invoice')->car ? $this->route('invoice')->car->id : null;

        if ($action === 'facture') {
            return [
                'client_id' => 'required|exists:clients,id',

                // Informations voiture
                'car.brand' => 'required|string|max:255',
                'car.model' => 'required|string|max:255',
                'car.ivn' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('cars', 'ivn')->ignore($carId),
                ],
                'car.registration_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('cars', 'registration_number')->ignore($carId),
                ],
                'car.chassis_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('cars', 'chassis_number')->ignore($carId),
                ],
                'car.color' => 'nullable|string|max:255',
                'car.year' => 'nullable|integer|min:1900|max:2099',

                // Informations facture
                'invoice.invoice_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('invoices', 'invoice_number')->ignore($invoiceId),
                ],
                'invoice.sale_date' => 'required|date',
                'invoice.total_amount' => 'required|numeric|min:0',
                'invoice.purchase_order_number' => 'required|string|max:255',
                'invoice.delivery_note_number' => 'required|string|max:255',
                'invoice.payment_order_reference' => 'required|string|max:255',

                // Images (validate only if uploaded, or check if they already exist for 'facturer')
                'image_invoice' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'image_bl' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'image_or' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'image_bc' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ];
        }

        // If the button is "save" (Brouillon/Draft) or if no action specified: no validation required
        return [];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',

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
            'invoice.purchase_order_number.required' => 'Le bon de commande est obligatoire.',
            'invoice.delivery_note_number.required' => 'Le bon de livraison est obligatoire.',
            'invoice.payment_order_reference.required' => 'L’ordre de réparation est obligatoire.',

            'image_invoice.file' => 'Le fichier de la facture doit être un fichier.',
            'image_invoice.mimes' => 'L’image de la facture doit être au format JPG, JPEG, PNG ou PDF.',
            'image_invoice.max' => 'L’image de la facture ne doit pas dépasser 10MB.',

            'image_bl.file' => 'Le fichier du bon de livraison doit être un fichier.',
            'image_bl.mimes' => 'L’image du bon de livraison doit être au format JPG, JPEG, PNG ou PDF.',
            'image_bl.max' => 'L’image du bon de livraison ne doit pas dépasser 10MB.',

            'image_or.file' => 'Le fichier de l’ordre de réparation doit être un fichier.',
            'image_or.mimes' => 'L’image de l’ordre de réparation doit être au format JPG, JPEG, PNG ou PDF.',
            'image_or.max' => 'L’image de l’ordre de réparation ne doit pas dépasser 10MB.',

            'image_bc.file' => 'Le fichier du bon de commande doit être un fichier.',
            'image_bc.mimes' => 'L’image du bon de commande doit être au format JPG, JPEG, PNG ou PDF.',
            'image_bc.max' => 'L’image du bon de commande ne doit pas dépasser 10MB.',
        ];
    }
}
