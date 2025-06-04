<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client.full_name' => 'required|string|max:255',
            'client.phone' => 'required|string|max:20',
            'client.cin' => 'required|string|max:50|unique:clients,cin',
            'client.address' => 'nullable|string|max:255',
            'client.email' => 'nullable|email|max:255',
            'client.branch_id' => 'required|exists:branches,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client.full_name.required' => 'Le nom complet est requis.',
            'client.phone.required' => 'Le numéro de téléphone est requis.',
            'client.cin.required' => 'La carte d\'identité nationale est requise.',
            'client.cin.unique' => 'Cette carte d\'identité nationale existe déjà.',
            'client.email.email' => 'L\'email doit être une adresse email valide.',
            'client.branch_id.required' => 'L\'agence est requise.',
            'client.branch_id.exists' => 'L\'agence sélectionnée n\'existe pas.',
        ];
    }
}
